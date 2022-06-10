<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation as JMS;


/**
 * @Signnow\XmlRoot("tag")
 * @Signnow\XmlNamespace(uri="http://purl.org/dc/elements/1.1/", prefix="dc")
 */
class Tag
{

    /**
     * @Signnow\XmlElement(cdata=false)
     * @Signnow\Type("string")
     */
    public $name;

    function __construct($name)
    {
        $this->name = $name;
    }


} 
