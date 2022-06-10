<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\Type;
use Signnow\Serializer\Annotation\XmlElement;
use Signnow\Serializer\Annotation\XmlNamespace;

/**
 * @XmlNamespace(uri="http://example.com/namespace-author")
 */
class ObjectWithXmlNamespacesAndObjectPropertyAuthor
{
    /**
     * @Type("string")
     * @XmlElement(namespace="http://example.com/namespace-modified");
     */
    private $author;

    /**
     * @Type("string")
     * @XmlElement(namespace="http://example.com/namespace-author");
     */
    private $info = "hidden-info";

    /**
     * @Type("string")
     * @XmlElement(namespace="http://example.com/namespace-property")
     */
    private $name;

    public function __construct($name, $author)
    {
        $this->name = $name;
        $this->author = $author;
    }
}
