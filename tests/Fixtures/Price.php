<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\Type;
use SignNow\Serializer\Annotation\XmlRoot;
use SignNow\Serializer\Annotation\XmlValue;

/**
 * @XmlRoot("price")
 */
class Price
{
    /**
     * @Type("float")
     * @XmlValue
     */
    private $price;

    public function __construct($price)
    {
        $this->price = $price;
    }
}
