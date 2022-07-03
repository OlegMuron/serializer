<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\Type;

class InlineChild
{
    /**
     * @Type("string")
     */
    public $a = 'a';

    /**
     * @Type("string")
     */
    public $b = 'b';
}
