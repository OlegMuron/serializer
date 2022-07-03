<?php

use SignNow\Serializer\Metadata\ClassMetadata;
use SignNow\Serializer\Metadata\PropertyMetadata;

$metadata = new ClassMetadata('SignNow\Serializer\Tests\Fixtures\Person');
$metadata->xmlRootName = 'child';

$pMetadata = new PropertyMetadata('SignNow\Serializer\Tests\Fixtures\Person', 'name');
$pMetadata->setType('string');
$pMetadata->xmlValue = true;
$pMetadata->xmlElementCData = false;
$metadata->addPropertyMetadata($pMetadata);

$pMetadata = new PropertyMetadata('SignNow\Serializer\Tests\Fixtures\Person', 'age');
$pMetadata->setType('integer');
$pMetadata->xmlAttribute = true;
$metadata->addPropertyMetadata($pMetadata);

return $metadata;
