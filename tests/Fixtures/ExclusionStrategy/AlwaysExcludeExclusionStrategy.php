<?php

namespace SignNow\Serializer\Tests\Fixtures\ExclusionStrategy;

use SignNow\Serializer\Context;
use SignNow\Serializer\Exclusion\ExclusionStrategyInterface;
use SignNow\Serializer\Metadata\ClassMetadata;
use SignNow\Serializer\Metadata\PropertyMetadata;

class AlwaysExcludeExclusionStrategy implements ExclusionStrategyInterface
{
    public function shouldSkipClass(ClassMetadata $metadata, Context $context)
    {
        return true;
    }

    public function shouldSkipProperty(PropertyMetadata $property, Context $context)
    {
        return false;
    }
}
