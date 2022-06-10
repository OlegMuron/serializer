<?php

namespace Signnow\Serializer\Tests\Metadata;

use Signnow\Serializer\Metadata\VirtualPropertyMetadata;
use Signnow\Serializer\Tests\Fixtures\ObjectWithVirtualProperties;

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
