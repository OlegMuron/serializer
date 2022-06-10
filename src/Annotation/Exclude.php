<?php

namespace Signnow\Serializer\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY", "CLASS", "METHOD", "ANNOTATION"})
 */
final class Exclude
{
    public $if;
}
