<?php

use Signnow\Serializer\Metadata\ClassMetadata;
use Signnow\Serializer\Metadata\PropertyMetadata;

$metadata = new ClassMetadata('Signnow\Serializer\Tests\Fixtures\Price');

$pMetadata = new PropertyMetadata('Signnow\Serializer\Tests\Fixtures\Price', 'price');
$pMetadata->setType('float');
$pMetadata->xmlValue = true;
$metadata->addPropertyMetadata($pMetadata);

return $metadata;
