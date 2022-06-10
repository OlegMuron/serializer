<?php

use Signnow\Serializer\Metadata\ClassMetadata;

$metadata = new ClassMetadata('Signnow\Serializer\Tests\Fixtures\Discriminator\ObjectWithXmlNamespaceDiscriminatorParent');
$metadata->setDiscriminator('type', array(
    'child' => 'Signnow\Serializer\Tests\Fixtures\Discriminator\ObjectWithXmlNamespaceDiscriminatorChild'
));
$metadata->xmlDiscriminatorNamespace = 'http://example.com/';

return $metadata;
