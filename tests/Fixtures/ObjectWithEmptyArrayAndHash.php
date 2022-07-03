<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation as Serializer;

class ObjectWithEmptyArrayAndHash
{
    /**
     * @Serializer\Type("array<string,string>")
     * @Serializer\SkipWhenEmpty()
     */
    private $hash = array();
    /**
     * @Serializer\Type("array<string>")
     * @Serializer\SkipWhenEmpty()
     */
    private $array = array();

    /**
     * @Serializer\SkipWhenEmpty()
     */
    private $object = array();

    public function __construct()
    {
        $this->object = new InlineChildEmpty();
    }
}
