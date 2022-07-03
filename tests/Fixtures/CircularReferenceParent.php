<?php

namespace SignNow\Serializer\Tests\Fixtures;

use Doctrine\Common\Collections\ArrayCollection;
use SignNow\Serializer\Annotation\PostDeserialize;
use SignNow\Serializer\Annotation\Type;

/** No annotation */
class CircularReferenceParent
{
    /** @Type("array<SignNow\Serializer\Tests\Fixtures\CircularReferenceChild>") */
    protected $collection = array();

    /** @Type("ArrayCollection<SignNow\Serializer\Tests\Fixtures\CircularReferenceChild>") */
    private $anotherCollection;

    public function __construct()
    {
        $this->collection[] = new CircularReferenceChild('child1', $this);
        $this->collection[] = new CircularReferenceChild('child2', $this);

        $this->anotherCollection = new ArrayCollection();
        $this->anotherCollection->add(new CircularReferenceChild('child1', $this));
        $this->anotherCollection->add(new CircularReferenceChild('child2', $this));
    }

    /** @PostDeserialize */
    private function afterDeserialization()
    {
        if (!$this->collection) {
            $this->collection = array();
        }
        foreach ($this->collection as $v) {
            $v->setParent($this);
        }

        if (!$this->anotherCollection) {
            $this->anotherCollection = new ArrayCollection();
        }
        foreach ($this->anotherCollection as $v) {
            $v->setParent($this);
        }
    }
}
