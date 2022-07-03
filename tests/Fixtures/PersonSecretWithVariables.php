<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation as Serializer;
use SignNow\Serializer\Context;
use SignNow\Serializer\Metadata\PropertyMetadata;

/**
 */
class PersonSecretWithVariables
{
    /**
     * @Serializer\Type("string")
     */
    public $name;

    /**
     * @Serializer\Type("string")
     * @Serializer\Expose(if="context.getDirection()==2 || object.test(property_metadata, context)")
     */
    public $gender;


    public function test(PropertyMetadata $propertyMetadata, Context $context)
    {
        return true;
    }
}
