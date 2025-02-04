<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\Type;
use SignNow\Serializer\Annotation\XmlElement;
use SignNow\Serializer\Annotation\XmlNamespace;

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
