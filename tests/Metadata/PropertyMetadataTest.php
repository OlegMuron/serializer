<?php

namespace SignNow\Serializer\Tests\Metadata;

use SignNow\Serializer\Metadata\PropertyMetadata;
use SignNow\Serializer\Tests\Fixtures\SimpleObject;

class PropertyMetadataTest extends AbstractPropertyMetadataTest
{
    public function testSerialization()
    {
        $meta = new PropertyMetadata(SimpleObject::class, 'foo');
        $this->setNonDefaultMetadataValues($meta);
        $meta->getter = 'getFoo';
        $meta->setter = 'setFoo';
        $meta->readOnly = true;

        $restoredMeta = unserialize(serialize($meta));
        $this->assertEquals($meta, $restoredMeta);
    }

}
