<?php

namespace SignNow\Serializer\Tests\Fixtures\Discriminator;

use SignNow\Serializer\Annotation as Serializer;

/**
 * @Serializer\Discriminator(field = "type", map = {
 *    "child": "SignNow\Serializer\Tests\Fixtures\Discriminator\ObjectWithXmlAttributeDiscriminatorChild"
 * })
 * @Serializer\XmlDiscriminator(attribute=true, cdata=false)
 */
class ObjectWithXmlAttributeDiscriminatorParent
{

}