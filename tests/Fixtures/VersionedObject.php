<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\SerializedName;
use Signnow\Serializer\Annotation\Since;
use Signnow\Serializer\Annotation\Until;

class VersionedObject
{
    /**
     * @Until("1.0.0")
     */
    private $name;

    /**
     * @Since("1.0.1")
     * @SerializedName("name")
     */
    private $name2;

    public function __construct($name, $name2)
    {
        $this->name = $name;
        $this->name2 = $name2;
    }
}
