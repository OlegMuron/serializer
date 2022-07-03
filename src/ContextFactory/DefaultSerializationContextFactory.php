<?php

namespace SignNow\Serializer\ContextFactory;

use SignNow\Serializer\SerializationContext;

/**
 * Default Serialization Context Factory.
 */
class DefaultSerializationContextFactory implements SerializationContextFactoryInterface
{
    /**
     * {@InheritDoc}
     */
    public function createSerializationContext()
    {
        return new SerializationContext();
    }
}
