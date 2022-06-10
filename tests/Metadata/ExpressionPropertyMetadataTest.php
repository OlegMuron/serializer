<?php

namespace Signnow\Serializer\Tests\Metadata;

use Signnow\Serializer\Metadata\ExpressionPropertyMetadata;

class ExpressionPropertyMetadataTest extends AbstractPropertyMetadataTest
{
    public function testSerialization()
    {
        $meta = new ExpressionPropertyMetadata('stdClass', 'foo', 'fooExpr');
        $this->setNonDefaultMetadataValues($meta);

        $restoredMeta = unserialize(serialize($meta));
        $this->assertEquals($meta, $restoredMeta);
    }
}
