<?php

use Signnow\Serializer\Metadata\ClassMetadata;

$metadata = new ClassMetadata('Signnow\Serializer\Tests\Fixtures\Discriminator\ObjectWithXmlAttributeDiscriminatorParent');
$metadata->setDiscriminator('type', array(
    'child' => 'Signnow\Serializer\Tests\Fixtures\Discriminator\ObjectWithXmlAttributeDiscriminatorChild'
));
$metadata->xmlDiscriminatorAttribute = true;
$metadata->xmlDiscriminatorCData = false;
return $metadata;
