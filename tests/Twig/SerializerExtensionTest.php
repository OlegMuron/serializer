<?php

namespace Signnow\Serializer\Tests\Twig;

use Signnow\Serializer\Twig\SerializerExtension;
use Signnow\Serializer\Twig\SerializerRuntimeExtension;
use Signnow\Serializer\Twig\SerializerRuntimeHelper;

class SerializerExtensionTest extends \PHPUnit\Framework\TestCase
{
    public function testSerialize()
    {
        $mockSerializer = $this->getMockBuilder('Signnow\Serializer\SerializerInterface')->getMock();
        $obj = new \stdClass();
        $mockSerializer
            ->expects($this->once())
            ->method('serialize')
            ->with($this->equalTo($obj), $this->equalTo('json'));
        $serializerExtension = new SerializerExtension($mockSerializer);
        $serializerExtension->serialize($obj);

        $this->assertEquals('jms_serializer', $serializerExtension->getName());

        $filters = $serializerExtension->getFilters();
        $this->assertInstanceOf('Twig_SimpleFilter', $filters[0]);
        $this->assertSame(array($serializerExtension, 'serialize'), $filters[0]->getCallable());

        $this->assertEquals(
            array(new \Twig_SimpleFunction('serialization_context', '\Signnow\Serializer\SerializationContext::create')),
            $serializerExtension->getFunctions()
        );
    }

    public function testRuntimeSerializerHelper()
    {
        $obj = new \stdClass();

        $mockSerializer = $this->getMockBuilder('Signnow\Serializer\SerializerInterface')->getMock();
        $mockSerializer
            ->expects($this->once())
            ->method('serialize')
            ->with($this->equalTo($obj), $this->equalTo('json'));

        $serializerExtension = new SerializerRuntimeHelper($mockSerializer);
        $serializerExtension->serialize($obj);
    }

    public function testRuntimeSerializerExtension()
    {
        $serializerExtension = new SerializerRuntimeExtension();

        $this->assertEquals('jms_serializer', $serializerExtension->getName());
        $this->assertEquals(
            array(new \Twig_SimpleFilter('serialize', array(SerializerRuntimeHelper::class, 'serialize'))),
            $serializerExtension->getFilters()
        );
        $this->assertEquals(
            array(new \Twig_SimpleFunction('serialization_context', '\Signnow\Serializer\SerializationContext::create')),
            $serializerExtension->getFunctions()
        );
    }
}
