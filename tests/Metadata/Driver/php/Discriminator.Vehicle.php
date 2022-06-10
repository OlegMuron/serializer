<?php

use Signnow\Serializer\Metadata\ClassMetadata;
use Signnow\Serializer\Metadata\PropertyMetadata;

$metadata = new ClassMetadata('Signnow\Serializer\Tests\Fixtures\Discriminator\Vehicle');
$metadata->setDiscriminator('type', array(
    'car' => 'Signnow\Serializer\Tests\Fixtures\Discriminator\Car',
    'moped' => 'Signnow\Serializer\Tests\Fixtures\Discriminator\Moped',
));

$km = new PropertyMetadata('Signnow\Serializer\Tests\Fixtures\Discriminator\Vehicle', 'km');
$km->setType('integer');
$metadata->addPropertyMetadata($km);

return $metadata;
