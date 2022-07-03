<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\Groups;
use SignNow\Serializer\Annotation\Type;

class InvalidGroupsObject
{
    /**
     * @Groups({"foo, bar"})
     * @Type("string")
     */
    private $foo;
}
