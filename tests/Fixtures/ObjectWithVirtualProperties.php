<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\AccessorOrder;
use SignNow\Serializer\Annotation\SerializedName;
use SignNow\Serializer\Annotation\Type;
use SignNow\Serializer\Annotation\VirtualProperty;
use SignNow\Serializer\Annotation\SkipWhenEmpty;

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
