<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\SerializedName;
use SignNow\Serializer\Annotation\Type;
use SignNow\Serializer\Annotation\XmlElement;
use SignNow\Serializer\Annotation\XmlNamespace;
use SignNow\Serializer\Annotation\XmlRoot;

/**
 * @XmlRoot("publisher")
 * @XmlNamespace(uri="http://example.com/namespace2", prefix="ns2")
 */
class Publisher
{
    /**
     * @Type("string")
     * @XmlElement(namespace="http://example.com/namespace2")
     * @SerializedName("pub_name")
     */
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}
