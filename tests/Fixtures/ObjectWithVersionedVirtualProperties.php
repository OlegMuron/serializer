<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\Groups;
use Signnow\Serializer\Annotation\SerializedName;
use Signnow\Serializer\Annotation\Since;
use Signnow\Serializer\Annotation\Until;
use Signnow\Serializer\Annotation\VirtualProperty;

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
