<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\Type;

class CustomDeserializationObject
{
    /**
     * @Type("string")
     */
    public $someProperty;

    public function __construct($value)
    {
        $this->someProperty = $value;
    }
}
