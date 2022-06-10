<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\Type;

class Garage
{
    /**
     * @Type("array<Signnow\Serializer\Tests\Fixtures\Discriminator\Vehicle>")
     */
    public $vehicles;

    public function __construct($vehicles)
    {
        $this->vehicles = $vehicles;
    }
}
