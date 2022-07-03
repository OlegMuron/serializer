<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\Type;
use SignNow\Serializer\Annotation\XmlAttribute;
use SignNow\Serializer\Annotation\XmlRoot;
use SignNow\Serializer\Annotation\XmlValue;

/**
 * @XmlRoot("child")
 */
class Person
{
    /**
     * @Type("string")
     * @XmlValue(cdata=false)
     */
    public $name;

    /**
     * @Type("int")
     * @XmlAttribute
     */
    public $age;
}
