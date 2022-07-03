<?php

namespace SignNow\Serializer\Naming;

use SignNow\Serializer\Metadata\PropertyMetadata;

class IdenticalPropertyNamingStrategy implements PropertyNamingStrategyInterface
{
    public function translateName(PropertyMetadata $property)
    {
        return $property->name;
    }
}
