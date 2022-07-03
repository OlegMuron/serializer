<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\Groups;
use SignNow\Serializer\Annotation\SerializedName;
use SignNow\Serializer\Annotation\Since;
use SignNow\Serializer\Annotation\Until;
use SignNow\Serializer\Annotation\VirtualProperty;

/**
 * dummy comment
 */
class ObjectWithVersionedVirtualProperties
{
    /**
     * @Groups({"versions"})
     * @VirtualProperty
     * @SerializedName("low")
     * @Until("8")
     */
    public function getVirualLowValue()
    {
        return 1;
    }

    /**
     * @Groups({"versions"})
     * @VirtualProperty
     * @SerializedName("high")
     * @Since("6")
     */
    public function getVirualHighValue()
    {
        return 8;
    }
}
