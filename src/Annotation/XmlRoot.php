<?php

namespace SignNow\Serializer\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
final class XmlRoot
{
    /**
     * @Required
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $namespace;
}
