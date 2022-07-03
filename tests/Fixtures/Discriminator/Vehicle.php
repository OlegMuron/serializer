<?php

namespace SignNow\Serializer\Tests\Fixtures\Discriminator;

use SignNow\Serializer\Annotation as Serializer;

/**
 * @Serializer\Discriminator(field = "type", map = {
 *    "car": "SignNow\Serializer\Tests\Fixtures\Discriminator\Car",
 *    "moped": "SignNow\Serializer\Tests\Fixtures\Discriminator\Moped",
 * })
 */
abstract class Vehicle
{
    /** @Serializer\Type("integer") */
    public $km;

    public function __construct($km)
    {
        $this->km = (integer)$km;
    }
}
