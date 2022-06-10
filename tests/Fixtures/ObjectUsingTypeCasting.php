<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation as Serializer;

class ObjectUsingTypeCasting
{
    /**
     * @var ObjectWithToString
     * @Serializer\Type("string")
     */
    public $asString;
}
