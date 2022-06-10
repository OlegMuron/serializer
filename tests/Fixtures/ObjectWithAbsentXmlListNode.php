<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation as Serializer;

class ObjectWithAbsentXmlListNode
{
    /**
     * @Serializer\XmlList(inline=false, entry="comment", skipWhenEmpty=true)
     * @Serializer\Type("array<string>")
     */
    public $absent;
    /**
     * @Serializer\XmlList(inline=false, entry="comment", skipWhenEmpty=false)
     * @Serializer\Type("array<string>")
     */
    public $present;

    /**
     * @Serializer\XmlList(inline=false, entry="comment")
     * @Serializer\Type("array<string>")
     */
    public $skipDefault;

    /**
     * @Serializer\XmlList(inline=false, namespace="http://www.example.com")
     * @Serializer\Type("array<string>")
     */
    public $absentAndNs;
}
