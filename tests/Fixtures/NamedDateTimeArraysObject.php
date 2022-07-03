<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\Type;
use SignNow\Serializer\Annotation\XmlKeyValuePairs;


class NamedDateTimeArraysObject
{
    /**
     * @var \DateTime[]
     * @Type("array<string,DateTime<'d.m.Y H:i:s'>>")
     * @XmlKeyValuePairs
     */
    private $namedArrayWithFormattedDate;

    function __construct($namedArrayWithFormattedDate)
    {
        $this->namedArrayWithFormattedDate = $namedArrayWithFormattedDate;
    }

    /**
     * @return \DateTime[]
     */
    public function getNamedArrayWithFormattedDate()
    {
        return $this->namedArrayWithFormattedDate;
    }
}
