<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\AccessorOrder;
use Signnow\Serializer\Annotation\SerializedName;
use Signnow\Serializer\Annotation\Type;
use Signnow\Serializer\Annotation\VirtualProperty;
use Signnow\Serializer\Annotation\SkipWhenEmpty;

/**
 * @AccessorOrder("custom", custom = {"prop_name", "existField", "foo" })
 */
class ObjectWithVirtualProperties
{

    /**
     * @Type("string")
     */
    protected $existField = 'value';

    /**
     *
     * @VirtualProperty
     */
    public function getVirtualValue()
    {
        return 'value';
    }

    /**
     * @VirtualProperty
     * @SerializedName("test")
     */
    public function getVirtualSerializedValue()
    {
        return 'other-name';
    }

    /**
     * @VirtualProperty
     * @Type("integer")
     */
    public function getTypedVirtualProperty()
    {
        return '1';
    }

    /**
     * @VirtualProperty
     * @SkipWhenEmpty()
     */
    public function getEmptyArray()
    {
        return [];
    }
}
