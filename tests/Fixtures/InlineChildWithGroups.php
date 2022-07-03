<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation as Serializer;
use SignNow\Serializer\Annotation\Type;

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
