<?php

namespace SignNow\Serializer\Tests\Serializer\EventDispatcher;

use Symfony\Component\DependencyInjection\Container;

class LazyEventDispatcherWithSymfonyContainerTest extends LazyEventDispatcherTest
{
    protected function createContainer()
    {
        return new Container();
    }

    protected function registerListenerService($serviceId, MockListener $listener)
    {
        $this->container->set($serviceId, $listener);
    }
}
