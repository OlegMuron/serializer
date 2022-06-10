<?php

use Signnow\Serializer\Metadata\ClassMetadata;
use Signnow\Serializer\Metadata\PropertyMetadata;

$metadata = new ClassMetadata('Signnow\Serializer\Tests\Fixtures\SimpleSubClassObject');

$metadata->registerNamespace('http://better.foo.example.org', 'foo');
$metadata->registerNamespace('http://foo.example.org', 'old_foo');

$pMetadata = new PropertyMetadata('Signnow\Serializer\Tests\Fixtures\SimpleSubClassObject', 'moo');
$pMetadata->setType('string');
$pMetadata->xmlNamespace = "http://better.foo.example.org";
$metadata->addPropertyMetadata($pMetadata);

$pMetadata = new PropertyMetadata('Signnow\Serializer\Tests\Fixtures\SimpleSubClassObject', 'baz');
$pMetadata->setType('string');
$pMetadata->xmlNamespace = "http://foo.example.org";
$metadata->addPropertyMetadata($pMetadata);

$pMetadata = new PropertyMetadata('Signnow\Serializer\Tests\Fixtures\SimpleSubClassObject', 'qux');
$pMetadata->setType('string');
$pMetadata->xmlNamespace = "http://new.foo.example.org";
$metadata->addPropertyMetadata($pMetadata);

return $metadata;