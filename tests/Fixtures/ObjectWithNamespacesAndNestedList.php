<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation as Serializer;
use Signnow\Serializer\Annotation\SerializedName;
use Signnow\Serializer\Annotation\Type;
use Signnow\Serializer\Annotation\XmlElement;
use Signnow\Serializer\Annotation\XmlList;
use Signnow\Serializer\Annotation\XmlMap;
use Signnow\Serializer\Annotation\XmlNamespace;
use Signnow\Serializer\Annotation\XmlRoot;

/**
 * @XmlRoot("ObjectWithNamespacesAndNestedList", namespace="http://example.com/namespace")
 * @XmlNamespace(uri="http://example.com/namespace")
 * @XmlNamespace(uri="http://example.com/namespace2", prefix="x")
 */
class ObjectWithNamespacesAndNestedList
{
    /**
     * @Type("Signnow\Serializer\Tests\Fixtures\PersonCollection")
     * @SerializedName("person_collection")
     */
    public $personCollection;
}

