<?php

use SignNow\Serializer\Metadata\ClassMetadata;
use SignNow\Serializer\Metadata\PropertyMetadata;

$metadata = new ClassMetadata('SignNow\Serializer\Tests\Fixtures\Discriminator\Post');
$metadata->setDiscriminator('type', array(
    'post' => 'SignNow\Serializer\Tests\Fixtures\Discriminator\Post',
    'image_post' => 'SignNow\Serializer\Tests\Fixtures\Discriminator\ImagePost',
));

$title = new PropertyMetadata('SignNow\Serializer\Tests\Fixtures\Discriminator\Post', 'title');
$title->setType('string');
$metadata->addPropertyMetadata($title);

return $metadata;
