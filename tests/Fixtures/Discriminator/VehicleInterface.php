<?php

namespace Signnow\Serializer\Tests\Fixtures\Discriminator;

use Signnow\Serializer\Annotation as Serializer;

/**
 * @Serializer\Discriminator(field = "type", map = {
 *    "car": "Signnow\Serializer\Tests\Fixtures\Discriminator\Car",
 *    "moped": "Signnow\Serializer\Tests\Fixtures\Discriminator\Moped",
 * })
 */
interface VehicleInterface
{
}
