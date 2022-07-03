<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\Groups;
use SignNow\Serializer\Annotation\Type;

/** blablub */
class GroupsObject
{
    /**
     * @Groups({"foo"})
     * @Type("string")
     */
    private $foo;

    /**
     * @Groups({"foo","bar"})
     * @Type("string")
     */
    private $foobar;

    /**
     * @Groups({"bar", "Default"})
     * @Type("string")
     */
    private $bar;

    /**
     * @Type("string")
     */
    private $none;

    public function __construct()
    {
        $this->foo = "foo";
        $this->bar = "bar";
        $this->foobar = "foobar";
        $this->none = "none";
    }
}
