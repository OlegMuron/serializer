<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\SerializedName;
use Signnow\Serializer\Annotation\Type;
use Signnow\Serializer\Annotation\XmlElement;
use Signnow\Serializer\Annotation\XmlNamespace;
use Signnow\Serializer\Annotation\XmlRoot;

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
