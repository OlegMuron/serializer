<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\Type;
use Signnow\Serializer\Annotation\XmlAttribute;
use Signnow\Serializer\Annotation\XmlRoot;
use Signnow\Serializer\Annotation\XmlValue;

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
