<?php

namespace Signnow\Serializer\ContextFactory;

use Signnow\Serializer\DeserializationContext;

/**
 * Default Deserialization Context Factory.
 */
class DefaultDeserializationContextFactory implements DeserializationContextFactoryInterface
{
    /**
     * {@InheritDoc}
     */
    public function createDeserializationContext()
    {
        return new DeserializationContext();
    }
}
