<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\Type;

class VehicleInterfaceGarage
{
    /**
     * @Type("array<Signnow\Serializer\Tests\Fixtures\Discriminator\VehicleInterface>")
     */
    public $vehicles;

    public function __construct($vehicles)
    {
        $this->vehicles = $vehicles;
    }
}
