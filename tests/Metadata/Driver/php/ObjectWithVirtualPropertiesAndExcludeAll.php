<?php

use Signnow\Serializer\Metadata\ClassMetadata;
use Signnow\Serializer\Metadata\VirtualPropertyMetadata;

$className = 'Signnow\Serializer\Tests\Fixtures\ObjectWithVirtualPropertiesAndExcludeAll';

$metadata = new ClassMetadata($className);

$pMetadata = new VirtualPropertyMetadata($className, 'virtualValue');
$pMetadata->getter = 'getVirtualValue';
$metadata->addPropertyMetadata($pMetadata);

return $metadata;
