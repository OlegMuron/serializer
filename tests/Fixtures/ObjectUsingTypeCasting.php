<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation as Serializer;

class ObjectUsingTypeCasting
{
    /**
     * @var ObjectWithToString
     * @Serializer\Type("string")
     */
    public $asString;
}
