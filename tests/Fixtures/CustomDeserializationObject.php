<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\Type;

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
