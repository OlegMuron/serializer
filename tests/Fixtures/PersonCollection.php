<?php

namespace SignNow\Serializer\Tests\Fixtures;

use Doctrine\Common\Collections\ArrayCollection;
use SignNow\Serializer\Annotation\Type;
use SignNow\Serializer\Annotation\XmlList;
use SignNow\Serializer\Annotation\XmlRoot;

/**
 * @XmlRoot("person_collection")
 */
class PersonCollection
{
    /**
     * @Type("ArrayCollection<SignNow\Serializer\Tests\Fixtures\Person>")
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
