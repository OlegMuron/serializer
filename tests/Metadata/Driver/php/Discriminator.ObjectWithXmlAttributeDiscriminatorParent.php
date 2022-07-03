<?php

use SignNow\Serializer\Metadata\ClassMetadata;

$metadata = new ClassMetadata('SignNow\Serializer\Tests\Fixtures\Discriminator\ObjectWithXmlAttributeDiscriminatorParent');
$metadata->setDiscriminator('type', array(
    'child' => 'SignNow\Serializer\Tests\Fixtures\Discriminator\ObjectWithXmlAttributeDiscriminatorChild'
));
$metadata->xmlDiscriminatorAttribute = true;
$metadata->xmlDiscriminatorCData = false;
return $metadata;
