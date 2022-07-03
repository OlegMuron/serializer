<?php

namespace SignNow\Serializer\Tests\Serializer\Naming;

use SignNow\Serializer\Naming\IdenticalPropertyNamingStrategy;

class IdenticalPropertyNamingStrategyTest extends \PHPUnit\Framework\TestCase
{
    public function providePropertyNames()
    {
        return array(
            array('createdAt'),
            array('my_field'),
            array('identical')
        );
    }

    /**
     * @dataProvider providePropertyNames
     */
    public function testTranslateName($propertyName)
    {
        $mockProperty = $this->getMockBuilder('SignNow\Serializer\Metadata\PropertyMetadata')->disableOriginalConstructor()->getMock();
        $mockProperty->name = $propertyName;

        $strategy = new IdenticalPropertyNamingStrategy();
        $this->assertEquals($propertyName, $strategy->translateName($mockProperty));
    }
}
