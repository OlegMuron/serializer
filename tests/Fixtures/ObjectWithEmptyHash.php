<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation as Serializer;

class ObjectWithEmptyHash
{
    /**
     * @Serializer\Type("array<string,string>")
     * @Serializer\XmlList(skipWhenEmpty=false)
     */
    private $hash = array();
}
