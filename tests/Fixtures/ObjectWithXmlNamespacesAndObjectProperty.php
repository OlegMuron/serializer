<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\Type;
use SignNow\Serializer\Annotation\XmlElement;
use SignNow\Serializer\Annotation\XmlNamespace;
use SignNow\Serializer\Annotation\XmlRoot;

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
     * @Type("SignNow\Serializer\Tests\Fixtures\ObjectWithXmlNamespacesAndObjectPropertyAuthor")
     * @XmlElement(namespace="http://example.com/namespace-property")
     */
    private $author;

    public function __construct($title, $author)
    {
        $this->title = $title;
        $this->author = $author;
    }
}
