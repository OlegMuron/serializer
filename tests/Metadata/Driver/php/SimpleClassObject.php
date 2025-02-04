<?php

use SignNow\Serializer\Metadata\ClassMetadata;
use SignNow\Serializer\Metadata\PropertyMetadata;

$metadata = new ClassMetadata('SignNow\Serializer\Tests\Fixtures\SimpleClassObject');

$metadata->registerNamespace('http://foo.example.org', 'foo');
$metadata->registerNamespace('http://old.foo.example.org', 'old_foo');
$metadata->registerNamespace('http://new.foo.example.org', 'new_foo');

$pMetadata = new PropertyMetadata('SignNow\Serializer\Tests\Fixtures\SimpleClassObject', 'foo');
$pMetadata->setType('string');
$pMetadata->xmlNamespace = "http://old.foo.example.org";
$pMetadata->xmlAttribute = true;
$metadata->addPropertyMetadata($pMetadata);

$pMetadata = new PropertyMetadata('SignNow\Serializer\Tests\Fixtures\SimpleClassObject', 'bar');
$pMetadata->setType('string');
$pMetadata->xmlNamespace = "http://foo.example.org";
$metadata->addPropertyMetadata($pMetadata);

$pMetadata = new PropertyMetadata('SignNow\Serializer\Tests\Fixtures\SimpleClassObject', 'moo');
$pMetadata->setType('string');
$pMetadata->xmlNamespace = "http://new.foo.example.org";
$metadata->addPropertyMetadata($pMetadata);

return $metadata;