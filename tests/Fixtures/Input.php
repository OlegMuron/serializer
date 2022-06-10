<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation as Serializer;

/**
 * @Serializer\XmlRoot("input")
 */
class Input
{
    /**
     * @Serializer\XmlAttributeMap
     */
    private $attributes;

    public function __construct($attributes = null)
    {
        $this->attributes = $attributes ?: array(
            'type' => 'text',
            'name' => 'firstname',
            'value' => 'Adrien',
        );
    }
}
