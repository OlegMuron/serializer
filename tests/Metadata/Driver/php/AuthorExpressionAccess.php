<?php

use SignNow\Serializer\Metadata\ClassMetadata;
use SignNow\Serializer\Metadata\ExpressionPropertyMetadata;
use SignNow\Serializer\Metadata\PropertyMetadata;
use SignNow\Serializer\Metadata\VirtualPropertyMetadata;

$metadata = new ClassMetadata('SignNow\Serializer\Tests\Fixtures\AuthorExpressionAccess');

$p = new ExpressionPropertyMetadata('SignNow\Serializer\Tests\Fixtures\AuthorExpressionAccess', 'firstName', 'object.getFirstName()');
$metadata->addPropertyMetadata($p);

$p = new VirtualPropertyMetadata('SignNow\Serializer\Tests\Fixtures\AuthorExpressionAccess', 'getLastName');
$metadata->addPropertyMetadata($p);

$p = new PropertyMetadata('SignNow\Serializer\Tests\Fixtures\AuthorExpressionAccess', 'id');
$metadata->addPropertyMetadata($p);

return $metadata;
