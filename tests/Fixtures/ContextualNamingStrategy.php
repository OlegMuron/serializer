<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Context;
use Signnow\Serializer\GraphNavigator;
use Signnow\Serializer\Metadata\PropertyMetadata;
use Signnow\Serializer\Naming\AdvancedNamingStrategyInterface;

/**
 * Class ContextualNamingStrategy
 *
 * Only use this class for testing purpose
 */
class ContextualNamingStrategy implements AdvancedNamingStrategyInterface
{
    public function getPropertyName(PropertyMetadata $property, Context $context)
    {
        if ($context->getDirection() == GraphNavigator::DIRECTION_SERIALIZATION) {
            return strtoupper($property->name);
        }
        return ucfirst($property->name);
    }
}
