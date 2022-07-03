<?php

namespace SignNow\Serializer\Tests\Handler;

use Doctrine\Common\Collections\ArrayCollection;
use SignNow\Serializer\Handler\ArrayCollectionHandler;
use SignNow\Serializer\Metadata\ClassMetadata;
use SignNow\Serializer\SerializationContext;
use SignNow\Serializer\Tests\Fixtures\ExclusionStrategy\AlwaysExcludeExclusionStrategy;
use SignNow\Serializer\VisitorInterface;
use Metadata\MetadataFactoryInterface;

class ArrayCollectionHandlerTest extends \PHPUnit\Framework\TestCase
{
    public function testSerializeArray()
    {
        $handler = new ArrayCollectionHandler();

        $visitor = $this->getMockBuilder(VisitorInterface::class)->getMock();
        $visitor->method('visitArray')->with(['foo'])->willReturn(['foo']);

        $context = $this->getMockBuilder(SerializationContext::class)->getMock();
        $type = ['name' => 'ArrayCollection', 'params' => []];

        $collection = new ArrayCollection(['foo']);

        $handler->serializeCollection($visitor, $collection, $type, $context);
    }

    public function testSerializeArraySkipByExclusionStrategy()
    {
        $handler = new ArrayCollectionHandler(false);

        $visitor = $this->getMockBuilder(VisitorInterface::class)->getMock();
        $visitor->method('visitArray')->with([])->willReturn([]);

        $context = $this->getMockBuilder(SerializationContext::class)->getMock();

        $factoryMock = $this->getMockBuilder(MetadataFactoryInterface::class)->getMock();
        $factoryMock->method('getMetadataForClass')->willReturn(new ClassMetadata(ArrayCollection::class));

        $context->method('getExclusionStrategy')->willReturn(new AlwaysExcludeExclusionStrategy());
        $context->method('getMetadataFactory')->willReturn($factoryMock);


        $type = ['name' => 'ArrayCollection', 'params' => []];

        $collection = new ArrayCollection(['foo']);

        $handler->serializeCollection($visitor, $collection, $type, $context);
    }
}
