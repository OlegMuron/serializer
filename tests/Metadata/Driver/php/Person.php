<?php

use Signnow\Serializer\Metadata\ClassMetadata;
use Signnow\Serializer\Metadata\PropertyMetadata;

$metadata = new ClassMetadata('Signnow\Serializer\Tests\Fixtures\Person');
$metadata->xmlRootName = 'child';

$pMetadata = new PropertyMetadata('Signnow\Serializer\Tests\Fixtures\Person', 'name');
$pMetadata->setType('string');
$pMetadata->xmlValue = true;
$pMetadata->xmlElementCData = false;
$metadata->addPropertyMetadata($pMetadata);

$pMetadata = new PropertyMetadata('Signnow\Serializer\Tests\Fixtures\Person', 'age');
$pMetadata->setType('integer');
$pMetadata->xmlAttribute = true;
$metadata->addPropertyMetadata($pMetadata);

return $metadata;
