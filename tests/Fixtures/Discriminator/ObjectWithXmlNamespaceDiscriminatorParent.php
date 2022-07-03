<?php

namespace SignNow\Serializer\Tests\Fixtures\Discriminator;

use SignNow\Serializer\Annotation as Serializer;

/**
 * @Serializer\Discriminator(field = "type", map = {
 *    "child": "SignNow\Serializer\Tests\Fixtures\Discriminator\ObjectWithXmlNamespaceDiscriminatorChild"
 * })
 * @Serializer\XmlDiscriminator(namespace="http://example.com/", cdata=false)
 * @Serializer\XmlNamespace(prefix="foo", uri="http://example.com/")
 */
class ObjectWithXmlNamespaceDiscriminatorParent
{

}
