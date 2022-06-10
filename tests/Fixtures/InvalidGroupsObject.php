<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\Groups;
use Signnow\Serializer\Annotation\Type;

class InvalidGroupsObject
{
    /**
     * @Groups({"foo, bar"})
     * @Type("string")
     */
    private $foo;
}
