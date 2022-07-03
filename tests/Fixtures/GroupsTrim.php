<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\Type;
use SignNow\Serializer\Annotation\Groups;

class GroupsTrim
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
