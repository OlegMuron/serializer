<?php

namespace Signnow\Serializer\Tests\Metadata;

use Signnow\Serializer\Metadata\StaticPropertyMetadata;

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
