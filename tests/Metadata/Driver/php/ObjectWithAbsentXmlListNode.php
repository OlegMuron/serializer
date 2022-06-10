<?php

use Signnow\Serializer\Metadata\ClassMetadata;
use Signnow\Serializer\Metadata\PropertyMetadata;

$className = 'Signnow\Serializer\Tests\Fixtures\ObjectWithAbsentXmlListNode';

$metadata = new ClassMetadata($className);

$pMetadata = new PropertyMetadata($className, 'absent');
$pMetadata->xmlCollectionSkipWhenEmpty = true;
$metadata->addPropertyMetadata($pMetadata);

$pMetadata = new PropertyMetadata($className, 'present');
$pMetadata->xmlCollectionSkipWhenEmpty = false;
$metadata->addPropertyMetadata($pMetadata);

$pMetadata = new PropertyMetadata($className, 'skipDefault');
$metadata->addPropertyMetadata($pMetadata);


return $metadata;
