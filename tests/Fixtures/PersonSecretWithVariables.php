<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation as Serializer;
use Signnow\Serializer\Context;
use Signnow\Serializer\Metadata\PropertyMetadata;

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
