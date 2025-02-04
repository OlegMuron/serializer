<?php

namespace SignNow\Serializer\Tests\Serializer;

use SignNow\Serializer\Handler\DateHandler;

class DateIntervalFormatTest extends \PHPUnit\Framework\TestCase
{
    public function testFormat()
    {
        $dtf = new DateHandler();

        $iso8601DateIntervalString = $dtf->format(new \DateInterval('P0D'));
        $this->assertEquals($iso8601DateIntervalString, 'P0DT0S');

        $iso8601DateIntervalString = $dtf->format(new \DateInterval('P0DT0S'));
        $this->assertEquals($iso8601DateIntervalString, 'P0DT0S');

        $iso8601DateIntervalString = $dtf->format(new \DateInterval('PT45M'));

        $this->assertEquals($iso8601DateIntervalString, 'PT45M');

        $iso8601DateIntervalString = $dtf->format(new \DateInterval('P2YT45M'));

        $this->assertEquals($iso8601DateIntervalString, 'P2YT45M');

        $iso8601DateIntervalString = $dtf->format(new \DateInterval('P2Y4DT6H8M16S'));

        $this->assertEquals($iso8601DateIntervalString, 'P2Y4DT6H8M16S');
    }
}
