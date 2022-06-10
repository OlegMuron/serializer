<?php

namespace Signnow\Serializer\ContextFactory;

use Signnow\Serializer\DeserializationContext;

/**
 * Deserialization Context Factory Interface.
 */
interface DeserializationContextFactoryInterface
{
    /**
     * @return DeserializationContext
     */
    public function createDeserializationContext();
}
