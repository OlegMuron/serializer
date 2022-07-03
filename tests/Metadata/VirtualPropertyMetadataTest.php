<?php

namespace SignNow\Serializer\Tests\Metadata;

use SignNow\Serializer\Metadata\VirtualPropertyMetadata;
use SignNow\Serializer\Tests\Fixtures\ObjectWithVirtualProperties;

class VirtualPropertyMetadataTest extends AbstractPropertyMetadataTest
{
    public function testSerialization()
    {
        $meta = new VirtualPropertyMetadata(ObjectWithVirtualProperties::class, 'getEmptyValue');
        $this->setNonDefaultMetadataValues($meta);

        $restoredMeta = unserialize(serialize($meta));
        $this->assertEquals($meta, $restoredMeta);
    }

}
