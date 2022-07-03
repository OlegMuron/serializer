<?php

namespace SignNow\Serializer\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD","ANNOTATION"})
 */
final class XmlAttribute
{
    /**
     * @var string
     */
    public $namespace;
}
