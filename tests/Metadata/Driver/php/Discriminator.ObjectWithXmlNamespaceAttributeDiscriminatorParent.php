<?php

use SignNow\Serializer\Metadata\ClassMetadata;

$metadata = new ClassMetadata('SignNow\Serializer\Tests\Fixtures\Discriminator\ObjectWithXmlNamespaceAttributeDiscriminatorParent');
$metadata->setDiscriminator('type', array(
    'child' => 'SignNow\Serializer\Tests\Fixtures\Discriminator\ObjectWithXmlNamespaceAttributeDiscriminatorChild'
));
$metadata->xmlDiscriminatorAttribute = true;
$metadata->xmlDiscriminatorNamespace = 'http://example.com/';

return $metadata;
