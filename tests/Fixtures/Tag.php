<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation as SignNow;


/**
 * @SignNow\XmlRoot("tag")
 * @SignNow\XmlNamespace(uri="http://purl.org/dc/elements/1.1/", prefix="dc")
 */
class Tag
{

    /**
     * @SignNow\XmlElement(cdata=false)
     * @SignNow\Type("string")
     */
    public $name;

    function __construct($name)
    {
        $this->name = $name;
    }


} 
