<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Doctrine\Common\Collections\ArrayCollection;
use Signnow\Serializer\Annotation\Type;
use Signnow\Serializer\Annotation\XmlList;
use Signnow\Serializer\Annotation\XmlRoot;

/**
 * @XmlRoot("person_collection")
 */
class PersonCollection
{
    /**
     * @Type("ArrayCollection<Signnow\Serializer\Tests\Fixtures\Person>")
     * @XmlList(entry = "person", inline = true)
     */
    public $persons;

    /**
     * @Type("string")
     */
    public $location;

    public function __construct()
    {
        $this->persons = new ArrayCollection;
    }
}
