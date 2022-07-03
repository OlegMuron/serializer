<?php
use SignNow\Serializer\Metadata\ClassMetadata;
use SignNow\Serializer\Metadata\PropertyMetadata;

$className = 'SignNow\Serializer\Tests\Fixtures\ObjectWithXmlKeyValuePairs';

$metadata = new ClassMetadata($className);

$pMetadata = new PropertyMetadata($className, 'array');
$pMetadata->xmlKeyValuePairs = true;
$metadata->addPropertyMetadata($pMetadata);

return $metadata;
