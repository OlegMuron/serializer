<?php

namespace SignNow\Serializer\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY", "CLASS", "METHOD", "ANNOTATION"})
 */
final class Exclude
{
    public $if;
}
