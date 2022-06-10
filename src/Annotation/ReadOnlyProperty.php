<?php

declare(strict_types=1);

namespace Signnow\Serializer\Annotation;

/**
 * @Annotation
 * @Target({"CLASS","PROPERTY"})
 *
 * @deprecated use `@ReadOnlyProperty` instead
 */
#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_PROPERTY)]
final class ReadOnlyProperty
{
    /**
     * @var bool
     */
    public $readOnly = true;
}