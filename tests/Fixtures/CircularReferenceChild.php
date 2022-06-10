<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\Type;

class CircularReferenceChild
{
    /** @Type("string") */
    private $name;

    /** @Type("Signnow\Serializer\Tests\Fixtures\CircularReferenceParent") */
    private $parent;

    public function __construct($name, CircularReferenceParent $parent)
    {
        $this->name = $name;
        $this->parent = $parent;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent(CircularReferenceParent $parent)
    {
        $this->parent = $parent;
    }
}
