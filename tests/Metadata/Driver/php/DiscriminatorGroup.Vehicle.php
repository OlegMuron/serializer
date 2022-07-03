<?php

use SignNow\Serializer\Metadata\ClassMetadata;
use SignNow\Serializer\Metadata\PropertyMetadata;

$metadata = new ClassMetadata('SignNow\Serializer\Tests\Fixtures\DiscriminatorGroup\Vehicle');
$metadata->setDiscriminator('type', array(
    'car' => 'SignNow\Serializer\Tests\Fixtures\DiscriminatorGroup\Car',
), array('foo'));

$km = new PropertyMetadata('SignNow\Serializer\Tests\Fixtures\DiscriminatorGroup\Vehicle', 'km');
$km->setType('integer');
$metadata->addPropertyMetadata($km);

return $metadata;
