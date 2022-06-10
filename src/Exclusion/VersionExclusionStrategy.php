<?php

namespace Signnow\Serializer\Exclusion;

use Signnow\Serializer\Context;
use Signnow\Serializer\Metadata\ClassMetadata;
use Signnow\Serializer\Metadata\PropertyMetadata;

class VersionExclusionStrategy implements ExclusionStrategyInterface
{
    private $version;

    public function __construct($version)
    {
        $this->version = $version;
    }

    /**
     * {@inheritDoc}
     */
    public function shouldSkipClass(ClassMetadata $metadata, Context $navigatorContext)
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function shouldSkipProperty(PropertyMetadata $property, Context $navigatorContext)
    {
        if ((null !== $version = $property->sinceVersion) && version_compare($this->version, $version, '<')) {
            return true;
        }

        if ((null !== $version = $property->untilVersion) && version_compare($this->version, $version, '>')) {
            return true;
        }

        return false;
    }
}
