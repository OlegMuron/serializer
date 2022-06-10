<?php

namespace Signnow\Serializer\Tests\Fixtures\ExclusionStrategy;

use Signnow\Serializer\Context;
use Signnow\Serializer\Exclusion\ExclusionStrategyInterface;
use Signnow\Serializer\Metadata\ClassMetadata;
use Signnow\Serializer\Metadata\PropertyMetadata;

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
