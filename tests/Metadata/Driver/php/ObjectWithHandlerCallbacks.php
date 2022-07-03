<?php

use SignNow\Serializer\GraphNavigator;
use SignNow\Serializer\Metadata\ClassMetadata;
use SignNow\Serializer\Metadata\PropertyMetadata;

$metadata = new ClassMetadata('SignNow\Serializer\Tests\Fixtures\ObjectWithHandlerCallbacks');

$pMetadata = new PropertyMetadata('SignNow\Serializer\Tests\Fixtures\ObjectWithHandlerCallbacks', 'name');
$pMetadata->type = 'string';
$metadata->addPropertyMetadata($pMetadata);

$metadata->addHandlerCallback(GraphNavigator::DIRECTION_SERIALIZATION, 'json', 'toJson');
$metadata->addHandlerCallback(GraphNavigator::DIRECTION_SERIALIZATION, 'xml', 'toXml');

return $metadata;
