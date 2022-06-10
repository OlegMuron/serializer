<?php

use Signnow\Serializer\Metadata\ClassMetadata;
use Signnow\Serializer\Metadata\ExpressionPropertyMetadata;

$className = 'Signnow\Serializer\Tests\Fixtures\ObjectWithExpressionVirtualPropertiesAndExcludeAll';

$metadata = new ClassMetadata($className);

$pMetadata = new ExpressionPropertyMetadata($className, 'virtualValue', 'object.getVirtualValue()');
$metadata->addPropertyMetadata($pMetadata);

return $metadata;
