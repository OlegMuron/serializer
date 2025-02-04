<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\SerializedName;
use SignNow\Serializer\Annotation\Type;

class SimpleObject
{
    /** @Type("string") */
    private $foo;

    /**
     * @SerializedName("moo")
     * @Type("string")
     */
    private $bar;

    /** @Type("string") */
    protected $camelCase = 'boo';

    public function __construct($foo, $bar)
    {
        $this->foo = $foo;
        $this->bar = $bar;
    }

    public function getFoo()
    {
        return $this->foo;
    }

    public function getBar()
    {
        return $this->bar;
    }
}
