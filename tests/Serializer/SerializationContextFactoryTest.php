<?php

namespace SignNow\Serializer\Tests\Serializer;

use Doctrine\Common\Annotations\AnnotationReader;
use SignNow\Serializer\Construction\UnserializeObjectConstructor;
use SignNow\Serializer\DeserializationContext;
use SignNow\Serializer\Handler\HandlerRegistry;
use SignNow\Serializer\JsonDeserializationVisitor;
use SignNow\Serializer\JsonSerializationVisitor;
use SignNow\Serializer\Metadata\Driver\AnnotationDriver;
use SignNow\Serializer\Naming\CamelCaseNamingStrategy;
use SignNow\Serializer\Naming\SerializedNameAnnotationStrategy;
use SignNow\Serializer\SerializationContext;
use SignNow\Serializer\Serializer;
use Metadata\MetadataFactory;
use PhpCollection\Map;

class SerializationContextFactoryTest extends \PHPUnit\Framework\TestCase
{
    protected $serializer;

    public function setUp(): void
    {
        parent::setUp();

        $namingStrategy = new SerializedNameAnnotationStrategy(new CamelCaseNamingStrategy());

        $this->serializer = new Serializer(
            new MetadataFactory(new AnnotationDriver(new AnnotationReader())),
            new HandlerRegistry(),
            new UnserializeObjectConstructor(),
            new Map(array('json' => new JsonSerializationVisitor($namingStrategy))),
            new Map(array('json' => new JsonDeserializationVisitor($namingStrategy)))
        );
    }

    public function testSerializeUseProvidedSerializationContext()
    {
        $contextFactoryMock = $this->getMockForAbstractClass('SignNow\\Serializer\\ContextFactory\\SerializationContextFactoryInterface');
        $context = new SerializationContext();
        $context->setSerializeNull(true);

        $contextFactoryMock
            ->expects($this->once())
            ->method('createSerializationContext')
            ->will($this->returnValue($context));

        $this->serializer->setSerializationContextFactory($contextFactoryMock);

        $result = $this->serializer->serialize(array('value' => null), 'json');

        $this->assertEquals('{"value":null}', $result);
    }

    public function testDeserializeUseProvidedDeserializationContext()
    {
        $contextFactoryMock = $this->getMockForAbstractClass('SignNow\\Serializer\\ContextFactory\\DeserializationContextFactoryInterface');
        $context = new DeserializationContext();

        $contextFactoryMock
            ->expects($this->once())
            ->method('createDeserializationContext')
            ->will($this->returnValue($context));

        $this->serializer->setDeserializationContextFactory($contextFactoryMock);

        $result = $this->serializer->deserialize('{"value":null}', 'array', 'json');

        $this->assertEquals(array('value' => null), $result);
    }

    public function testToArrayUseProvidedSerializationContext()
    {
        $contextFactoryMock = $this->getMockForAbstractClass('SignNow\\Serializer\\ContextFactory\\SerializationContextFactoryInterface');
        $context = new SerializationContext();
        $context->setSerializeNull(true);

        $contextFactoryMock
            ->expects($this->once())
            ->method('createSerializationContext')
            ->will($this->returnValue($context));

        $this->serializer->setSerializationContextFactory($contextFactoryMock);

        $result = $this->serializer->toArray(array('value' => null));

        $this->assertEquals(array('value' => null), $result);
    }

    public function testFromArrayUseProvidedDeserializationContext()
    {
        $contextFactoryMock = $this->getMockForAbstractClass('SignNow\\Serializer\\ContextFactory\\DeserializationContextFactoryInterface');
        $context = new DeserializationContext();

        $contextFactoryMock
            ->expects($this->once())
            ->method('createDeserializationContext')
            ->will($this->returnValue($context));

        $this->serializer->setDeserializationContextFactory($contextFactoryMock);

        $result = $this->serializer->fromArray(array('value' => null), 'array');

        $this->assertEquals(array('value' => null), $result);
    }
}
