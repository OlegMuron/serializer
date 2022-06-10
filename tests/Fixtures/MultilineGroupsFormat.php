<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\Type;
use Signnow\Serializer\Annotation\Groups;

class MultilineGroupsFormat
{
    /**
     * @var int
     */
    private $amount;

    /**
     * @var string
     */
    private $currency;

    public function __construct($amount, $currency)
    {
        $this->amount = (int) $amount;
        $this->currency = $currency;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getCurrency()
    {
        return $this->currency;
    }
}
