<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation as Serializer;

class ObjectWithEmptyHash
{
    /**
     * @Serializer\Type("array<string,string>")
     * @Serializer\XmlList(skipWhenEmpty=false)
     */
    private $hash = array();
}
