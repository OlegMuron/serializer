<?php

namespace Signnow\Serializer\ContextFactory;

use Signnow\Serializer\SerializationContext;

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
