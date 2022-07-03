<?php

use SignNow\Serializer\Metadata\ClassMetadata;
use SignNow\Serializer\Metadata\PropertyMetadata;

$metadata = new ClassMetadata('SignNow\Serializer\Tests\Fixtures\Node');

$pMetadata = new PropertyMetadata('SignNow\Serializer\Tests\Fixtures\Node', 'children');
$pMetadata->maxDepth = 2;
$metadata->addPropertyMetadata($pMetadata);

return $metadata;
