<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Construction\ObjectConstructorInterface;
use SignNow\Serializer\DeserializationContext;
use SignNow\Serializer\Metadata\ClassMetadata;
use SignNow\Serializer\VisitorInterface;

/**
 * Object constructor that allows deserialization into already constructed
 * objects passed through the deserialization context
 */
class InitializedObjectConstructor implements ObjectConstructorInterface
{
    private $fallbackConstructor;

    /**
     * Constructor.
     *
     * @param ObjectConstructorInterface $fallbackConstructor Fallback object constructor
     */
    public function __construct(ObjectConstructorInterface $fallbackConstructor)
    {
        $this->fallbackConstructor = $fallbackConstructor;
    }

    /**
     * {@inheritdoc}
     */
    public function construct(VisitorInterface $visitor, ClassMetadata $metadata, $data, array $type, DeserializationContext $context)
    {
        if ($context->attributes->containsKey('target') && $context->getDepth() === 1) {
            return $context->attributes->get('target')->get();
        }

        return $this->fallbackConstructor->construct($visitor, $metadata, $data, $type, $context);
    }

}
