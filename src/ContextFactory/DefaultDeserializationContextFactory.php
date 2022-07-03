<?php

namespace SignNow\Serializer\ContextFactory;

use SignNow\Serializer\DeserializationContext;

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
