<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation as Serializer;

final class ObjectWithInlineArray
{
    /**
     * @Serializer\Inline()
     * @Serializer\Type("array<string,string>")
     */
    public $array;

    /**
     * @param array $array
     */
    public function __construct(array $array)
    {
        $this->array = $array;
    }
}
