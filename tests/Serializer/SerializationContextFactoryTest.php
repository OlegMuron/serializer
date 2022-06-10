<?php

namespace Signnow\Serializer\Tests\Serializer;

use Doctrine\Common\Annotations\AnnotationReader;
use Signnow\Serializer\Construction\UnserializeObjectConstructor;
use Signnow\Serializer\DeserializationContext;
use Signnow\Serializer\Handler\HandlerRegistry;
use Signnow\Serializer\JsonDeserializationVisitor;
use Signnow\Serializer\JsonSerializationVisitor;
use Signnow\Serializer\Metadata\Driver\AnnotationDriver;
use Signnow\Serializer\Naming\CamelCaseNamingStrategy;
use Signnow\Serializer\Naming\SerializedNameAnnotationStrategy;
use Signnow\Serializer\SerializationContext;
use Signnow\Serializer\Serializer;
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
        $contextFactoryMock = $this->getMockForAbstractClass('Signnow\\Serializer\\ContextFactory\\SerializationContextFactoryInterface');
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
        $contextFactoryMock = $this->getMockForAbstractClass('Signnow\\Serializer\\ContextFactory\\DeserializationContextFactoryInterface');
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
        $contextFactoryMock = $this->getMockForAbstractClass('Signnow\\Serializer\\ContextFactory\\SerializationContextFactoryInterface');
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
        $contextFactoryMock = $this->getMockForAbstractClass('Signnow\\Serializer\\ContextFactory\\DeserializationContextFactoryInterface');
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
