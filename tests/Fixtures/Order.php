<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\Type;
use Signnow\Serializer\Annotation\XmlRoot;

/** @XmlRoot("order") */
class Order
{
    /** @Type("Signnow\Serializer\Tests\Fixtures\Price") */
    private $cost;

    public function __construct(Price $price = null)
    {
        $this->cost = $price ?: new Price(5);
    }
}
