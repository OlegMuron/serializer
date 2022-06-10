<?php

namespace Signnow\Serializer\Tests\Fixtures\Discriminator;

use Signnow\Serializer\Annotation as Serializer;

/**
 * @Serializer\Discriminator(field = "type", map = {
 *    "child": "Signnow\Serializer\Tests\Fixtures\Discriminator\ObjectWithXmlNotCDataDiscriminatorChild"
 * })
 * @Serializer\XmlDiscriminator(cdata=false)
 */
class ObjectWithXmlNotCDataDiscriminatorParent
{

}
