<?php

namespace SignNow\Serializer\Tests\Fixtures\DiscriminatorGroup;

use SignNow\Serializer\Annotation as Serializer;

/**
 * @Serializer\Discriminator(field = "type", groups={"foo"}, map = {
 *    "car": "SignNow\Serializer\Tests\Fixtures\DiscriminatorGroup\Car"
 * })
 */
abstract class Vehicle
{
    /**
     * @Serializer\Type("integer")
     * @Serializer\Groups({"foo"})
     */
    public $km;

    public function __construct($km)
    {
        $this->km = (integer)$km;
    }
}
