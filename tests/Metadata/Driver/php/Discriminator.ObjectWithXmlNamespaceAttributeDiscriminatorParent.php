<?php

use Signnow\Serializer\Metadata\ClassMetadata;

$metadata = new ClassMetadata('Signnow\Serializer\Tests\Fixtures\Discriminator\ObjectWithXmlNamespaceAttributeDiscriminatorParent');
$metadata->setDiscriminator('type', array(
    'child' => 'Signnow\Serializer\Tests\Fixtures\Discriminator\ObjectWithXmlNamespaceAttributeDiscriminatorChild'
));
$metadata->xmlDiscriminatorAttribute = true;
$metadata->xmlDiscriminatorNamespace = 'http://example.com/';

return $metadata;
