<?php

namespace SignNow\Serializer\Tests\Serializer\EventDispatcher;

use SignNow\Serializer\EventDispatcher\Event;
use SignNow\Serializer\EventDispatcher\EventDispatcher;
use SignNow\Serializer\EventDispatcher\EventDispatcherInterface;
use SignNow\Serializer\EventDispatcher\EventSubscriberInterface;
use SignNow\Serializer\EventDispatcher\ObjectEvent;

class EventDispatcherTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var EventDispatcher
     */
    protected $dispatcher;
    protected $event;

    public function testHasListeners()
    {
        $this->assertFalse($this->dispatcher->hasListeners('foo', 'Foo', 'json'));
        $this->dispatcher->addListener('foo', function () {
        });
        $this->assertTrue($this->dispatcher->hasListeners('foo', 'Foo', 'json'));

        $this->assertFalse($this->dispatcher->hasListeners('bar', 'Bar', 'json'));
        $this->dispatcher->addListener('bar', function () {
        }, 'Foo');
        $this->assertFalse($this->dispatcher->hasListeners('bar', 'Bar', 'json'));
        $this->dispatcher->addListener('bar', function () {
        }, 'Bar', 'xml');
        $this->assertFalse($this->dispatcher->hasListeners('bar', 'Bar', 'json'));
        $this->dispatcher->addListener('bar', function () {
        }, null, 'json');
        $this->assertTrue($this->dispatcher->hasListeners('bar', 'Baz', 'json'));
        $this->assertTrue($this->dispatcher->hasListeners('bar', 'Bar', 'json'));

        $this->assertFalse($this->dispatcher->hasListeners('baz', 'Bar', 'xml'));
        $this->dispatcher->addListener('baz', function () {
        }, 'Bar');
        $this->assertTrue($this->dispatcher->hasListeners('baz', 'Bar', 'xml'));
        $this->assertTrue($this->dispatcher->hasListeners('baz', 'bAr', 'xml'));
    }

    public function testDispatch()
    {
        $a = new MockListener();
        $this->dispatcher->addListener('foo', array($a, 'foo'));
        $this->dispatch('bar');
        $a->_verify('Listener is not called for other event.');

        $b = new MockListener();
        $this->dispatcher->addListener('pre', array($b, 'bar'), 'Bar');
        $this->dispatcher->addListener('pre', array($b, 'foo'), 'Foo');
        $this->dispatcher->addListener('pre', array($b, 'all'));

        $b->bar($this->event, 'pre', 'bar', 'json', $this->dispatcher);
        $b->all($this->event, 'pre', 'bar', 'json', $this->dispatcher);
        $b->foo($this->event, 'pre', 'foo', 'json', $this->dispatcher);
        $b->all($this->event, 'pre', 'foo', 'json', $this->dispatcher);
        $b->_replay();
        $this->dispatch('pre', 'Bar');
        $this->dispatch('pre', 'Foo');
        $b->_verify();
    }

    public function testListenerCanStopPropagation()
    {
        $listener1 = false;
        $listener2 = false;

        $this->dispatcher->addListener('pre', function (Event $event) use (&$listener1) {
            $event->stopPropagation();
            $listener1 = true;
        });

        $this->dispatcher->addListener('pre', function () use (&$listener2) {
            $listener2 = true;
        });

        $this->dispatch('pre');

        $this->assertTrue($listener1);
        $this->assertFalse($listener2);
    }

    public function testListenerCanDispatchEvent()
    {
        $listener1 = false;
        $listener2 = false;
        $listener3 = false;

        $this->dispatcher->addListener('pre', function (Event $event, $eventName, $loweredClass, $format, EventDispatcherInterface $dispatcher) use (&$listener1) {
            $listener1 = true;

            $event = new Event($event->getContext(), $event->getType());

            $this->assertSame('pre', $eventName);
            $this->assertSame('json', $format);
            $this->assertSame('foo', $loweredClass);

            $dispatcher->dispatch('post', 'Blah', 'xml', $event);
        });

        $this->dispatcher->addListener('pre', function () use (&$listener2) {
            $listener2 = true;
        });

        $this->dispatcher->addListener('post', function (Event $event, $eventName, $loweredClass, $format, EventDispatcherInterface $dispatcher) use (&$listener3) {
            $listener3 = true;

            $this->assertSame('post', $eventName);
            $this->assertSame('xml', $format);
            $this->assertSame('blah', $loweredClass);
        });

        $this->dispatch('pre');

        $this->assertTrue($listener1);
        $this->assertTrue($listener2);
        $this->assertTrue($listener3);
    }

    public function testAddSubscriber()
    {
        $subscriber = new MockSubscriber();
        MockSubscriber::$events = array(
            array('event' => 'foo.bar_baz', 'format' => 'foo'),
            array('event' => 'bar', 'method' => 'bar', 'class' => 'foo'),
        );

        $this->dispatcher->addSubscriber($subscriber);
        $this->assertAttributeEquals(array(
            'foo.bar_baz' => array(
                array(array($subscriber, 'onfoobarbaz'), null, 'foo'),
            ),
            'bar' => array(
                array(array($subscriber, 'bar'), 'foo', null),
            ),
        ), 'listeners', $this->dispatcher);
    }

    protected function setUp(): void
    {
        $this->dispatcher = $this->createEventDispatcher();
        $this->event = new ObjectEvent($this->getMockBuilder('SignNow\Serializer\Context')->getMock(), new \stdClass(), array('name' => 'foo', 'params' => array()));
    }

    protected function createEventDispatcher()
    {
        return new EventDispatcher();
    }

    protected function dispatch($eventName, $class = 'Foo', $format = 'json', Event $event = null)
    {
        $this->dispatcher->dispatch($eventName, $class, $format, $event ?: $this->event);
    }
}

class MockSubscriber implements EventSubscriberInterface
{
    public static $events = array();

    public static function getSubscribedEvents()
    {
        return self::$events;
    }
}

class MockListener
{
    private $expected = array();
    private $actual = array();
    private $wasReplayed = false;

    public function __call($method, array $args = array())
    {
        if (!$this->wasReplayed) {
            $this->expected[] = array($method, $args);

            return;
        }

        $this->actual[] = array($method, $args);
    }

    public function _replay()
    {
        $this->wasReplayed = true;
    }

    public function _verify($message = '')
    {
        \PHPUnit\Framework\Assert::assertSame($this->expected, $this->actual, $message);
    }
}
