<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\Type;
use Signnow\Serializer\Annotation\XmlRoot;
use Signnow\Serializer\Annotation\XmlValue;

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
