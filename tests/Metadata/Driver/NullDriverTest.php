<?php

namespace SignNow\Serializer\Tests\Metadata\Driver;

use SignNow\Serializer\Metadata\ClassMetadata;
use SignNow\Serializer\Metadata\Driver\NullDriver;

class NullDriverTest extends \PHPUnit\Framework\TestCase
{
    public function testReturnsValidMetadata()
    {
        $driver = new NullDriver();

        $metadata = $driver->loadMetadataForClass(new \ReflectionClass('stdClass'));

        $this->assertInstanceOf(ClassMetadata::class, $metadata);
        $this->assertCount(0, $metadata->propertyMetadata);
    }
}
