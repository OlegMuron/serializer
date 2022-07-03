<?php

use SignNow\Serializer\Metadata\ClassMetadata;
use SignNow\Serializer\Metadata\PropertyMetadata;

$metadata = new ClassMetadata('SignNow\Serializer\Tests\Fixtures\Discriminator\Vehicle');
$metadata->setDiscriminator('type', array(
    'car' => 'SignNow\Serializer\Tests\Fixtures\Discriminator\Car',
    'moped' => 'SignNow\Serializer\Tests\Fixtures\Discriminator\Moped',
));

$km = new PropertyMetadata('SignNow\Serializer\Tests\Fixtures\Discriminator\Vehicle', 'km');
$km->setType('integer');
$metadata->addPropertyMetadata($km);

return $metadata;
