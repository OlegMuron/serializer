<?php

namespace Signnow\Serializer\Naming;

use Signnow\Serializer\Metadata\PropertyMetadata;

class IdenticalPropertyNamingStrategy implements PropertyNamingStrategyInterface
{
    public function translateName(PropertyMetadata $property)
    {
        return $property->name;
    }
}
