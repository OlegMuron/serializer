<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\Type;
use SignNow\Serializer\Annotation\XmlRoot;

/** @XmlRoot("order") */
class Order
{
    /** @Type("SignNow\Serializer\Tests\Fixtures\Price") */
    private $cost;

    public function __construct(Price $price = null)
    {
        $this->cost = $price ?: new Price(5);
    }
}
