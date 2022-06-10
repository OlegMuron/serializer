<?php

use Signnow\Serializer\Metadata\ClassMetadata;
use Signnow\Serializer\Metadata\PropertyMetadata;

$metadata = new ClassMetadata('Signnow\Serializer\Tests\Fixtures\Node');

$pMetadata = new PropertyMetadata('Signnow\Serializer\Tests\Fixtures\Node', 'children');
$pMetadata->maxDepth = 2;
$metadata->addPropertyMetadata($pMetadata);

return $metadata;
