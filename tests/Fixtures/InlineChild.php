<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\Type;

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
