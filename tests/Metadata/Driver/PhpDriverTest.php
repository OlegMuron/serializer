<?php

namespace Signnow\Serializer\Tests\Metadata\Driver;

use Signnow\Serializer\Metadata\Driver\PhpDriver;
use Metadata\Driver\FileLocator;

class PhpDriverTest extends BaseDriverTest
{
    protected function getDriver()
    {
        return new PhpDriver(new FileLocator(array(
            'Signnow\Serializer\Tests\Fixtures' => __DIR__ . '/php',
        )));
    }
}
