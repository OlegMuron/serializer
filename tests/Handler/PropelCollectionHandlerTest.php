<?php

namespace SignNow\Serializer\Tests\Handler;

use SignNow\Serializer\SerializerBuilder;

class PropelCollectionHandlerTest extends \PHPUnit\Framework\TestCase
{
    /** @var  $serializer \SignNow\Serializer\Serializer */
    private $serializer;

    public function setUp(): void
    {
        $this->serializer = SerializerBuilder::create()
            ->addDefaultHandlers()//load PropelCollectionHandler
            ->build();
    }

    public function testSerializePropelObjectCollection()
    {
        $collection = new \PropelObjectCollection();
        $collection->setData(array(new TestSubject('lolo'), new TestSubject('pepe')));
        $json = $this->serializer->serialize($collection, 'json');

        $data = json_decode($json, true);

        $this->assertCount(2, $data); //will fail if PropelCollectionHandler not loaded

        foreach ($data as $testSubject) {
            $this->assertArrayHasKey('name', $testSubject);
        }
    }
}

class TestSubject
{
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }
}
