<?php

use Signnow\Serializer\Metadata\ClassMetadata;
use Signnow\Serializer\Metadata\PropertyMetadata;

$metadata = new ClassMetadata('Signnow\Serializer\Tests\Fixtures\DiscriminatorGroup\Vehicle');
$metadata->setDiscriminator('type', array(
    'car' => 'Signnow\Serializer\Tests\Fixtures\DiscriminatorGroup\Car',
), array('foo'));

$km = new PropertyMetadata('Signnow\Serializer\Tests\Fixtures\DiscriminatorGroup\Vehicle', 'km');
$km->setType('integer');
$metadata->addPropertyMetadata($km);

return $metadata;
