<?php

use Signnow\Serializer\Metadata\ClassMetadata;
use Signnow\Serializer\Metadata\PropertyMetadata;

$metadata = new ClassMetadata('Signnow\Serializer\Tests\Fixtures\PersonSecret');

$pMetadata = new PropertyMetadata('Signnow\Serializer\Tests\Fixtures\PersonSecret', 'name');
$pMetadata->setType('string');
$metadata->addPropertyMetadata($pMetadata);

$pMetadata = new PropertyMetadata('Signnow\Serializer\Tests\Fixtures\PersonSecret', 'gender');
$pMetadata->setType('string');
$pMetadata->excludeIf = "show_data('gender')";
$metadata->addPropertyMetadata($pMetadata);

$pMetadata = new PropertyMetadata('Signnow\Serializer\Tests\Fixtures\PersonSecret', 'age');
$pMetadata->setType('string');
$pMetadata->excludeIf = "!(show_data('age'))";
$metadata->addPropertyMetadata($pMetadata);

return $metadata;
