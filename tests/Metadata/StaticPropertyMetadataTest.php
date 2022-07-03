<?php

namespace SignNow\Serializer\Tests\Metadata;

use SignNow\Serializer\Metadata\StaticPropertyMetadata;

class StaticPropertyMetadataTest extends AbstractPropertyMetadataTest
{
    public function testSerialization()
    {
        $meta = new StaticPropertyMetadata('stdClass', 'foo', 'fooVal');
        $this->setNonDefaultMetadataValues($meta);

        $restoredMeta = unserialize(serialize($meta));
        $this->assertEquals($meta, $restoredMeta);
    }
}
