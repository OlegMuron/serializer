<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\Type;
use Signnow\Serializer\Annotation\XmlElement;
use Signnow\Serializer\Annotation\XmlNamespace;
use Signnow\Serializer\Annotation\XmlRoot;

/**
 * @XmlRoot("property:test-object", namespace="http://example.com/namespace-property")
 * @XmlNamespace(uri="http://example.com/namespace-property", prefix="property")
 */
class ObjectWithXmlNamespacesAndObjectProperty
{
    /**
     * @Type("string")
     * @XmlElement(namespace="http://example.com/namespace-property");
     */
    private $title;

    /**
     * @Type("Signnow\Serializer\Tests\Fixtures\ObjectWithXmlNamespacesAndObjectPropertyAuthor")
     * @XmlElement(namespace="http://example.com/namespace-property")
     */
    private $author;

    public function __construct($title, $author)
    {
        $this->title = $title;
        $this->author = $author;
    }
}
