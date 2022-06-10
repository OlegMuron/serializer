<?php

use Signnow\Serializer\Metadata\ClassMetadata;
use Signnow\Serializer\Metadata\PropertyMetadata;

$metadata = new ClassMetadata('Signnow\Serializer\Tests\Fixtures\Discriminator\Post');
$metadata->setDiscriminator('type', array(
    'post' => 'Signnow\Serializer\Tests\Fixtures\Discriminator\Post',
    'image_post' => 'Signnow\Serializer\Tests\Fixtures\Discriminator\ImagePost',
));

$title = new PropertyMetadata('Signnow\Serializer\Tests\Fixtures\Discriminator\Post', 'title');
$title->setType('string');
$metadata->addPropertyMetadata($title);

return $metadata;
