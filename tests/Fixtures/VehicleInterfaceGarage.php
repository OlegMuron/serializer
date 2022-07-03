<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\Type;

class VehicleInterfaceGarage
{
    /**
     * @Type("array<SignNow\Serializer\Tests\Fixtures\Discriminator\VehicleInterface>")
     */
    public $vehicles;

    public function __construct($vehicles)
    {
        $this->vehicles = $vehicles;
    }
}
