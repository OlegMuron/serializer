<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\Type;
use Signnow\Serializer\Annotation\XmlRoot;

/**
 * @XmlRoot("person_location")
 */
class PersonLocation
{
    /**
     * @Type("Signnow\Serializer\Tests\Fixtures\Person")
     */
    public $person;

    /**
     * @Type("string")
     */
    public $location;
}
