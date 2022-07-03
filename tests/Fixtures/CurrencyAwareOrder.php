<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\Type;
use SignNow\Serializer\Annotation\XmlRoot;

/** @XmlRoot("order") */
class CurrencyAwareOrder
{
    /** @Type("SignNow\Serializer\Tests\Fixtures\CurrencyAwarePrice") */
    private $cost;

    public function __construct(CurrencyAwarePrice $price = null)
    {
        $this->cost = $price ?: new CurrencyAwarePrice(5);
    }
}
