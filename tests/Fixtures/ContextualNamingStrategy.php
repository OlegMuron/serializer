<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Context;
use SignNow\Serializer\GraphNavigator;
use SignNow\Serializer\Metadata\PropertyMetadata;
use SignNow\Serializer\Naming\AdvancedNamingStrategyInterface;

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
