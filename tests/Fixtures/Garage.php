<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\Type;

class Garage
{
    /**
     * @Type("array<SignNow\Serializer\Tests\Fixtures\Discriminator\Vehicle>")
     */
    public $vehicles;

    public function __construct($vehicles)
    {
        $this->vehicles = $vehicles;
    }
}
