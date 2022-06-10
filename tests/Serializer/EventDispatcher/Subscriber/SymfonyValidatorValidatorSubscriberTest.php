<?php

namespace Signnow\Serializer\Tests\Serializer\EventDispatcher\Subscriber;

use Signnow\Serializer\DeserializationContext;
use Signnow\Serializer\EventDispatcher\EventDispatcher;
use Signnow\Serializer\EventDispatcher\ObjectEvent;
use Signnow\Serializer\EventDispatcher\Subscriber\SymfonyValidatorSubscriber;
use Signnow\Serializer\EventDispatcher\Subscriber\SymfonyValidatorValidatorSubscriber;
use Signnow\Serializer\SerializerBuilder;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

class SymfonyValidatorValidatorSubscriberTest extends \PHPUnit\Framework\TestCase
{
    private $validator;

    /** @var SymfonyValidatorSubscriber */
    private $subscriber;

    public function testValidate()
    {
        $obj = new \stdClass;

        $this->validator->expects($this->once())
            ->method('validate')
            ->with($obj, null, array('foo'))
            ->will($this->returnValue(new ConstraintViolationList()));

        $context = DeserializationContext::create()->setAttribute('validation_groups', array('foo'));

        $this->subscriber->onPostDeserialize(new ObjectEvent($context, $obj, array()));
    }

    /**
     * @expectedException \Signnow\Serializer\Exception\ValidationFailedException
     * @expectedExceptionMessage Validation failed with 1 error(s).
     */
    public function testValidateThrowsExceptionWhenListIsNotEmpty()
    {
        $obj = new \stdClass;

        $this->validator->expects($this->once())
            ->method('validate')
            ->with($obj, null, array('foo'))
            ->will($this->returnValue(new ConstraintViolationList(array(new ConstraintViolation('foo', 'foo', array(), 'a', 'b', 'c')))));

        $context = DeserializationContext::create()->setAttribute('validation_groups', array('foo'));

        $this->subscriber->onPostDeserialize(new ObjectEvent($context, $obj, array()));
    }

    public function testValidatorIsNotCalledWhenNoGroupsAreSet()
    {
        $this->validator->expects($this->never())
            ->method('validate');

        $this->subscriber->onPostDeserialize(new ObjectEvent(DeserializationContext::create(), new \stdClass, array()));
    }

    public function testValidationIsOnlyPerformedOnRootObject()
    {
        $this->validator->expects($this->once())
            ->method('validate')
            ->with($this->isInstanceOf('Signnow\Serializer\Tests\Fixtures\AuthorList'), null, array('Foo'))
            ->will($this->returnValue(new ConstraintViolationList()));

        $subscriber = $this->subscriber;
        $list = SerializerBuilder::create()
            ->configureListeners(function (EventDispatcher $dispatcher) use ($subscriber) {
                $dispatcher->addSubscriber($subscriber);
            })
            ->build()
            ->deserialize(
                '{"authors":[{"full_name":"foo"},{"full_name":"bar"}]}',
                'Signnow\Serializer\Tests\Fixtures\AuthorList',
                'json',
                DeserializationContext::create()->setAttribute('validation_groups', array('Foo'))
            );

        $this->assertCount(2, $list);
    }

    protected function setUp(): void
    {
        if (!interface_exists('Symfony\Component\Validator\Validator\ValidatorInterface')) {
            $this->markTestSkipped('Symfony\Component\Validator\Validator\ValidatorInterface ^2.6|^3.0 is not available');
        }

        $this->validator = $this->getMockBuilder('Symfony\Component\Validator\Validator\ValidatorInterface')->getMock();
        $this->subscriber = new SymfonyValidatorValidatorSubscriber($this->validator);
    }
}
