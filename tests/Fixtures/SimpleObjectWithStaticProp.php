<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\SerializedName;
use SignNow\Serializer\Annotation\Type;

class SimpleObjectWithStaticProp
{
    /** @Type("string") */
    private static $foo;

    /**
     * @SerializedName("moo")
     * @Type("string")
     */
    private static $bar;

    /** @Type("string") */
    protected static $camelCase = 'boo';

    public function __construct($foo, $bar)
    {
        self::$foo = $foo;
        self::$bar = $bar;
    }
}
