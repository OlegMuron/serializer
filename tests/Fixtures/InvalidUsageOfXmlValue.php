<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\XmlValue;

/** Dummy */
class InvalidUsageOfXmlValue
{
    /** @XmlValue */
    private $value = 'bar';

    private $element = 'foo';
}
