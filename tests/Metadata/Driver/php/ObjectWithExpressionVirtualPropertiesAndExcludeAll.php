<?php

use SignNow\Serializer\Metadata\ClassMetadata;
use SignNow\Serializer\Metadata\ExpressionPropertyMetadata;

$className = 'SignNow\Serializer\Tests\Fixtures\ObjectWithExpressionVirtualPropertiesAndExcludeAll';

$metadata = new ClassMetadata($className);

$pMetadata = new ExpressionPropertyMetadata($className, 'virtualValue', 'object.getVirtualValue()');
$metadata->addPropertyMetadata($pMetadata);

return $metadata;
