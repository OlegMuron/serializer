<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation as Serializer;
use SignNow\Serializer\Annotation\SerializedName;
use SignNow\Serializer\Annotation\Type;
use SignNow\Serializer\Annotation\XmlElement;
use SignNow\Serializer\Annotation\XmlList;
use SignNow\Serializer\Annotation\XmlMap;
use SignNow\Serializer\Annotation\XmlNamespace;
use SignNow\Serializer\Annotation\XmlRoot;

/**
 * @XmlRoot("ObjectWithNamespacesAndNestedList", namespace="http://example.com/namespace")
 * @XmlNamespace(uri="http://example.com/namespace")
 * @XmlNamespace(uri="http://example.com/namespace2", prefix="x")
 */
class ObjectWithNamespacesAndNestedList
{
    /**
     * @Type("SignNow\Serializer\Tests\Fixtures\PersonCollection")
     * @SerializedName("person_collection")
     */
    public $personCollection;
}

