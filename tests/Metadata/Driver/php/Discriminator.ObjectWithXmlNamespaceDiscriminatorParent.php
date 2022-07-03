<?php

use SignNow\Serializer\Metadata\ClassMetadata;

$metadata = new ClassMetadata('SignNow\Serializer\Tests\Fixtures\Discriminator\ObjectWithXmlNamespaceDiscriminatorParent');
$metadata->setDiscriminator('type', array(
    'child' => 'SignNow\Serializer\Tests\Fixtures\Discriminator\ObjectWithXmlNamespaceDiscriminatorChild'
));
$metadata->xmlDiscriminatorNamespace = 'http://example.com/';

return $metadata;
