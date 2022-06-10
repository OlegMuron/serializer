<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation as Serializer;
use Signnow\Serializer\Annotation\Type;

class InlineChildWithGroups
{
    /**
     * @Type("string")
     * @Serializer\Groups({"a"})
     */
    public $a = 'a';

    /**
     * @Type("string")
     * @Serializer\Groups({"b"})
     */
    public $b = 'b';
}
