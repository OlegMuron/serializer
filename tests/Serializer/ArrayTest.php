<?php

namespace Signnow\Serializer\Tests\Serializer;

use Doctrine\Common\Annotations\AnnotationReader;
use Signnow\Serializer\Construction\UnserializeObjectConstructor;
use Signnow\Serializer\Handler\HandlerRegistry;
use Signnow\Serializer\JsonDeserializationVisitor;
use Signnow\Serializer\JsonSerializationVisitor;
use Signnow\Serializer\Metadata\Driver\AnnotationDriver;
use Signnow\Serializer\Naming\CamelCaseNamingStrategy;
use Signnow\Serializer\Naming\SerializedNameAnnotationStrategy;
use Signnow\Serializer\Serializer;
use Signnow\Serializer\Tests\Fixtures\Author;
use Signnow\Serializer\Tests\Fixtures\AuthorList;
use Signnow\Serializer\Tests\Fixtures\Order;
use Signnow\Serializer\Tests\Fixtures\Price;
use Metadata\MetadataFactory;
use PhpCollection\Map;

class ArrayTest extends \PHPUnit\Framework\TestCase
{
    protected $serializer;

    public function setUp(): void
    {
        $namingStrategy = new SerializedNameAnnotationStrategy(new CamelCaseNamingStrategy());

        $this->serializer = new Serializer(
            new MetadataFactory(new AnnotationDriver(new AnnotationReader())),
            new HandlerRegistry(),
            new UnserializeObjectConstructor(),
            new Map(array('json' => new JsonSerializationVisitor($namingStrategy))),
            new Map(array('json' => new JsonDeserializationVisitor($namingStrategy)))
        );
    }

    public function testToArray()
    {
        $order = new Order(new Price(5));

        $expected = array(
            'cost' => array(
                'price' => 5
            )
        );

        $result = $this->serializer->toArray($order);

        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider scalarValues
     */
    public function testToArrayWithScalar($input)
    {
        $this->expectException('Signnow\Serializer\Exception\RuntimeException');
        $this->expectExceptionMessage(sprintf(
            'The input data of type "%s" did not convert to an array, but got a result of type "%s".',
            gettype($input),
            gettype($input)
        ));
        $result = $this->serializer->toArray($input);

        $this->assertEquals(array($input), $result);
    }

    public function scalarValues()
    {
        return array(
            array(42),
            array(3.14159),
            array('helloworld'),
            array(true),
        );
    }

    public function testFromArray()
    {
        $data = array(
            'cost' => array(
                'price' => 2.5
            )
        );

        $expected = new Order(new Price(2.5));
        $result = $this->serializer->fromArray($data, 'Signnow\Serializer\Tests\Fixtures\Order');

        $this->assertEquals($expected, $result);
    }

    public function testToArrayReturnsArrayObjectAsArray()
    {
        $result = $this->serializer->toArray(new Author(null));

        $this->assertSame(array(), $result);
    }

    public function testToArrayConversNestedArrayObjects()
    {
        $list = new AuthorList();
        $list->add(new Author(null));

        $result = $this->serializer->toArray($list);
        $this->assertSame(array('authors' => array(array())), $result);
    }
}
