<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\Type;
use SignNow\Serializer\Annotation\XmlRoot;

/**
 * @XmlRoot("person_location")
 */
class PersonLocation
{
    /**
     * @Type("SignNow\Serializer\Tests\Fixtures\Person")
     */
    public $person;

    /**
     * @Type("string")
     */
    public $location;
}
