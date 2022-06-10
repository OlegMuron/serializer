<?php
use Signnow\Serializer\Metadata\ClassMetadata;
use Signnow\Serializer\Metadata\PropertyMetadata;

$className = 'Signnow\Serializer\Tests\Fixtures\ObjectWithXmlKeyValuePairs';

$metadata = new ClassMetadata($className);

$pMetadata = new PropertyMetadata($className, 'array');
$pMetadata->xmlKeyValuePairs = true;
$metadata->addPropertyMetadata($pMetadata);

return $metadata;
