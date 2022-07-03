<?php

use SignNow\Serializer\Metadata\ClassMetadata;
use SignNow\Serializer\Metadata\PropertyMetadata;

$metadata = new ClassMetadata('SignNow\Serializer\Tests\Fixtures\PersonSecret');

$pMetadata = new PropertyMetadata('SignNow\Serializer\Tests\Fixtures\PersonSecret', 'name');
$pMetadata->setType('string');
$metadata->addPropertyMetadata($pMetadata);

$pMetadata = new PropertyMetadata('SignNow\Serializer\Tests\Fixtures\PersonSecret', 'gender');
$pMetadata->setType('string');
$pMetadata->excludeIf = "show_data('gender')";
$metadata->addPropertyMetadata($pMetadata);

$pMetadata = new PropertyMetadata('SignNow\Serializer\Tests\Fixtures\PersonSecret', 'age');
$pMetadata->setType('string');
$pMetadata->excludeIf = "!(show_data('age'))";
$metadata->addPropertyMetadata($pMetadata);

return $metadata;
