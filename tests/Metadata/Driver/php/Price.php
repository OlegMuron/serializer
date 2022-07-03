<?php

use SignNow\Serializer\Metadata\ClassMetadata;
use SignNow\Serializer\Metadata\PropertyMetadata;

$metadata = new ClassMetadata('SignNow\Serializer\Tests\Fixtures\Price');

$pMetadata = new PropertyMetadata('SignNow\Serializer\Tests\Fixtures\Price', 'price');
$pMetadata->setType('float');
$pMetadata->xmlValue = true;
$metadata->addPropertyMetadata($pMetadata);

return $metadata;
