<?php

use SignNow\Serializer\Metadata\ClassMetadata;
use SignNow\Serializer\Metadata\VirtualPropertyMetadata;

$className = 'SignNow\Serializer\Tests\Fixtures\ObjectWithVirtualPropertiesAndExcludeAll';

$metadata = new ClassMetadata($className);

$pMetadata = new VirtualPropertyMetadata($className, 'virtualValue');
$pMetadata->getter = 'getVirtualValue';
$metadata->addPropertyMetadata($pMetadata);

return $metadata;
