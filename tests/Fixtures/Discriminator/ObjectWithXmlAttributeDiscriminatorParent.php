<?php

namespace Signnow\Serializer\Tests\Fixtures\Discriminator;

use Signnow\Serializer\Annotation as Serializer;

/**
 * @Serializer\Discriminator(field = "type", map = {
 *    "child": "Signnow\Serializer\Tests\Fixtures\Discriminator\ObjectWithXmlAttributeDiscriminatorChild"
 * })
 * @Serializer\XmlDiscriminator(attribute=true, cdata=false)
 */
class ObjectWithXmlAttributeDiscriminatorParent
{

}