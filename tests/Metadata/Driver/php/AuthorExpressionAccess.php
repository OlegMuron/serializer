<?php

use Signnow\Serializer\Metadata\ClassMetadata;
use Signnow\Serializer\Metadata\ExpressionPropertyMetadata;
use Signnow\Serializer\Metadata\PropertyMetadata;
use Signnow\Serializer\Metadata\VirtualPropertyMetadata;

$metadata = new ClassMetadata('Signnow\Serializer\Tests\Fixtures\AuthorExpressionAccess');

$p = new ExpressionPropertyMetadata('Signnow\Serializer\Tests\Fixtures\AuthorExpressionAccess', 'firstName', 'object.getFirstName()');
$metadata->addPropertyMetadata($p);

$p = new VirtualPropertyMetadata('Signnow\Serializer\Tests\Fixtures\AuthorExpressionAccess', 'getLastName');
$metadata->addPropertyMetadata($p);

$p = new PropertyMetadata('Signnow\Serializer\Tests\Fixtures\AuthorExpressionAccess', 'id');
$metadata->addPropertyMetadata($p);

return $metadata;
