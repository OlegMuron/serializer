<?php

namespace SignNow\Serializer\Tests\Metadata\Driver;

use SignNow\Serializer\Metadata\Driver\PhpDriver;
use Metadata\Driver\FileLocator;

class PhpDriverTest extends BaseDriverTest
{
    protected function getDriver()
    {
        return new PhpDriver(new FileLocator(array(
            'SignNow\Serializer\Tests\Fixtures' => __DIR__ . '/php',
        )));
    }
}
