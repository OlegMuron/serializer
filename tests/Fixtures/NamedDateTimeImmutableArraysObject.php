<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\Type;
use SignNow\Serializer\Annotation\XmlKeyValuePairs;

class NamedDateTimeImmutableArraysObject
{
    /**
     * @var \DateTime[]
     * @Type("array<string,DateTimeImmutable<'d.m.Y H:i:s'>>")
     * @XmlKeyValuePairs
     */
    private $namedArrayWithFormattedDate;

    function __construct($namedArrayWithFormattedDate)
    {
        $this->namedArrayWithFormattedDate = $namedArrayWithFormattedDate;
    }

    /**
     * @return \DateTimeImmutable[]
     */
    public function getNamedArrayWithFormattedDate()
    {
        return $this->namedArrayWithFormattedDate;
    }
}
