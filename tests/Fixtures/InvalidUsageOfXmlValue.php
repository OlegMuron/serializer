<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\XmlValue;

/** Dummy */
class InvalidUsageOfXmlValue
{
    /** @XmlValue */
    private $value = 'bar';

    private $element = 'foo';
}
