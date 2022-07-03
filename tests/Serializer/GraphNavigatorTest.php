<?php

namespace SignNow\Serializer\Tests\Serializer;

use Doctrine\Common\Annotations\AnnotationReader;
use SignNow\Serializer\Construction\UnserializeObjectConstructor;
use SignNow\Serializer\EventDispatcher\EventDispatcher;
use SignNow\Serializer\GraphNavigator;
use SignNow\Serializer\Handler\HandlerRegistry;
use SignNow\Serializer\Handler\SubscribingHandlerInterface;
use SignNow\Serializer\Metadata\Driver\AnnotationDriver;
use Metadata\MetadataFactory;

class GraphNavigatorTest extends \PHPUnit\Framework\TestCase
{
    private $metadataFactory;
    private $handlerRegistry;
    private $objectConstructor;
    private $dispatcher;
    private $navigator;
    private $context;

    /**
     * @expectedException SignNow\Serializer\Exception\RuntimeException
     * @expectedExceptionMessage Resources are not supported in serialized data.
     */
    public function testResourceThrowsException()
    {
        $this->context->expects($this->any())
            ->method('getDirection')
            ->will($this->returnValue(GraphNavigator::DIRECTION_SERIALIZATION));

        $this->navigator->accept(STDIN, null, $this->context);
    }

    public function testNavigatorPassesInstanceOnSerialization()
    {
        $object = new SerializableClass;
        $metadata = $this->metadataFactory->getMetadataForClass(get_class($object));

        $self = $this;
        $context = $this->context;
        $exclusionStrategy = $this->getMockBuilder('SignNow\Serializer\Exclusion\ExclusionStrategyInterface')->getMock();
        $exclusionStrategy->expects($this->once())
            ->method('shouldSkipClass')
            ->will($this->returnCallback(function ($passedMetadata, $passedContext) use ($metadata, $context, $self) {
                $self->assertSame($metadata, $passedMetadata);
                $self->assertSame($context, $passedContext);
            }));
        $exclusionStrategy->expects($this->once())
            ->method('shouldSkipProperty')
            ->will($this->returnCallback(function ($propertyMetadata, $passedContext) use ($context, $metadata, $self) {
                $self->assertSame($metadata->propertyMetadata['foo'], $propertyMetadata);
                $self->assertSame($context, $passedContext);
            }));

        $this->context->expects($this->once())
            ->method('getExclusionStrategy')
            ->will($this->returnValue($exclusionStrategy));

        $this->context->expects($this->any())
            ->method('getDirection')
            ->will($this->returnValue(GraphNavigator::DIRECTION_SERIALIZATION));

        $this->context->expects($this->any())
            ->method('getVisitor')
            ->will($this->returnValue($this->getMockBuilder('SignNow\Serializer\VisitorInterface')->getMock()));

        $this->navigator = new GraphNavigator($this->metadataFactory, $this->handlerRegistry, $this->objectConstructor, $this->dispatcher);
        $this->navigator->accept($object, null, $this->context);
    }

    public function testNavigatorPassesNullOnDeserialization()
    {
        $class = __NAMESPACE__ . '\SerializableClass';
        $metadata = $this->metadataFactory->getMetadataForClass($class);

        $context = $this->context;
        $exclusionStrategy = $this->getMockBuilder('SignNow\Serializer\Exclusion\ExclusionStrategyInterface')->getMock();
        $exclusionStrategy->expects($this->once())
            ->method('shouldSkipClass')
            ->with($metadata, $this->callback(function ($navigatorContext) use ($context) {
                return $navigatorContext === $context;
            }));

        $exclusionStrategy->expects($this->once())
            ->method('shouldSkipProperty')
            ->with($metadata->propertyMetadata['foo'], $this->callback(function ($navigatorContext) use ($context) {
                return $navigatorContext === $context;
            }));

        $this->context->expects($this->once())
            ->method('getExclusionStrategy')
            ->will($this->returnValue($exclusionStrategy));

        $this->context->expects($this->any())
            ->method('getDirection')
            ->will($this->returnValue(GraphNavigator::DIRECTION_DESERIALIZATION));

        $this->context->expects($this->any())
            ->method('getVisitor')
            ->will($this->returnValue($this->getMockBuilder('SignNow\Serializer\VisitorInterface')->getMock()));

        $this->navigator = new GraphNavigator($this->metadataFactory, $this->handlerRegistry, $this->objectConstructor, $this->dispatcher);
        $this->navigator->accept('random', array('name' => $class, 'params' => array()), $this->context);
    }

    public function testNavigatorChangeTypeOnSerialization()
    {
        $object = new SerializableClass;
        $typeName = 'JsonSerializable';

        $this->dispatcher->addListener('serializer.pre_serialize', function ($event) use ($typeName) {
            $type = $event->getType();
            $type['name'] = $typeName;
            $event->setType($type['name'], $type['params']);
        });

        $this->handlerRegistry->registerSubscribingHandler(new TestSubscribingHandler());

        $this->context->expects($this->any())
            ->method('getDirection')
            ->will($this->returnValue(GraphNavigator::DIRECTION_SERIALIZATION));

        $this->context->expects($this->any())
            ->method('getVisitor')
            ->will($this->returnValue($this->getMockBuilder('SignNow\Serializer\VisitorInterface')->getMock()));

        $this->navigator = new GraphNavigator($this->metadataFactory, $this->handlerRegistry, $this->objectConstructor, $this->dispatcher);
        $this->navigator->accept($object, null, $this->context);
    }

    protected function setUp(): void
    {
        $this->context = $this->getMockBuilder('SignNow\Serializer\Context')->getMock();
        $this->dispatcher = new EventDispatcher();
        $this->handlerRegistry = new HandlerRegistry();
        $this->objectConstructor = new UnserializeObjectConstructor();

        $this->metadataFactory = new MetadataFactory(new AnnotationDriver(new AnnotationReader()));
        $this->navigator = new GraphNavigator($this->metadataFactory, $this->handlerRegistry, $this->objectConstructor, $this->dispatcher);
    }
}

class SerializableClass
{
    public $foo = 'bar';
}

class TestSubscribingHandler implements SubscribingHandlerInterface
{
    public static function getSubscribingMethods()
    {
        return array(array(
            'type' => 'JsonSerializable',
            'format' => 'foo',
            'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
            'method' => 'serialize'
        ));
    }
}
