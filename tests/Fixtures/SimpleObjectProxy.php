<?php

namespace SignNow\Serializer\Tests\Fixtures;

use Doctrine\Persistence\Proxy;

class SimpleObjectProxy extends SimpleObject implements Proxy
{
    public $__isInitialized__ = false;

    private $baz = 'baz';

    public function __load()
    {
        if (!$this->__isInitialized__) {
            $this->camelCase = 'proxy-boo';
            $this->__isInitialized__ = true;
        }
    }

    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }
}
