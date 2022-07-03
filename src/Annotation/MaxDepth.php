<?php

namespace SignNow\Serializer\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY","METHOD","ANNOTATION"})
 */
final class MaxDepth
{
    /**
     * @Required
     * @var integer
     */
    public $depth;
}
