<?php

namespace SignNow\Serializer\Tests\Fixtures;

use SignNow\Serializer\Annotation\Type;

class Timestamp
{
    /**
     * @Type("DateTime<'U'>")
     */
    private $timestamp;

    public function __construct($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }
}
