<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\Type;
use SignNow\Serializer\Annotation\XmlAttribute;
use SignNow\Serializer\Annotation\XmlElement;
use SignNow\Serializer\Annotation\XmlNamespace;

/**
 * @XmlNamespace(prefix="old_foo", uri="http://old.foo.example.org");
 * @XmlNamespace(prefix="foo", uri="http://foo.example.org");
 * @XmlNamespace(prefix="new_foo", uri="http://new.foo.example.org");
 */
class SimpleClassObject
{
    /**
     * @Type("string")
     * @XmlAttribute(namespace="http://old.foo.example.org")
     */
    public $foo;

    /**
     * @Type("string")
     * @XmlElement(namespace="http://foo.example.org")
     */
    public $bar;

    /**
     * @Type("string")
     * @XmlElement(namespace="http://new.foo.example.org")
     */
    public $moo;

}
