<?php

use Signnow\Serializer\GraphNavigator;
use Signnow\Serializer\Metadata\ClassMetadata;
use Signnow\Serializer\Metadata\PropertyMetadata;

$metadata = new ClassMetadata('Signnow\Serializer\Tests\Fixtures\ObjectWithHandlerCallbacks');

$pMetadata = new PropertyMetadata('Signnow\Serializer\Tests\Fixtures\ObjectWithHandlerCallbacks', 'name');
$pMetadata->type = 'string';
$metadata->addPropertyMetadata($pMetadata);

$metadata->addHandlerCallback(GraphNavigator::DIRECTION_SERIALIZATION, 'json', 'toJson');
$metadata->addHandlerCallback(GraphNavigator::DIRECTION_SERIALIZATION, 'xml', 'toXml');

return $metadata;
