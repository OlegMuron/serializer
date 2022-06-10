<?php

namespace Signnow\Serializer\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD","ANNOTATION"})
 */
final class Type
{
    /**
     * @Required
     * @var string
     */
    public $name;
}
