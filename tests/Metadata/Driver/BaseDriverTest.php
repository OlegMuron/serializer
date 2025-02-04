<?php

namespace SignNow\Serializer\Tests\Metadata\Driver;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use SignNow\Serializer\GraphNavigator;
use SignNow\Serializer\Metadata\ClassMetadata;
use SignNow\Serializer\Metadata\ExpressionPropertyMetadata;
use SignNow\Serializer\Metadata\PropertyMetadata;
use SignNow\Serializer\Metadata\VirtualPropertyMetadata;
use SignNow\Serializer\Tests\Fixtures\Discriminator\ObjectWithXmlAttributeDiscriminatorChild;
use SignNow\Serializer\Tests\Fixtures\Discriminator\ObjectWithXmlAttributeDiscriminatorParent;
use SignNow\Serializer\Tests\Fixtures\Discriminator\ObjectWithXmlNamespaceAttributeDiscriminatorChild;
use SignNow\Serializer\Tests\Fixtures\Discriminator\ObjectWithXmlNamespaceAttributeDiscriminatorParent;
use SignNow\Serializer\Tests\Fixtures\Discriminator\ObjectWithXmlNamespaceDiscriminatorChild;
use SignNow\Serializer\Tests\Fixtures\Discriminator\ObjectWithXmlNamespaceDiscriminatorParent;
use SignNow\Serializer\Tests\Fixtures\ObjectWithExpressionVirtualPropertiesAndExcludeAll;
use SignNow\Serializer\Tests\Fixtures\ObjectWithVirtualPropertiesAndExcludeAll;
use SignNow\Serializer\Tests\Fixtures\ParentSkipWithEmptyChild;
use Metadata\Driver\DriverInterface;

abstract class BaseDriverTest extends TestCase
{
    public function testLoadBlogPostMetadata()
    {
        $m = $this->getDriver()->loadMetadataForClass(new ReflectionClass('SignNow\Serializer\Tests\Fixtures\BlogPost'));

        $this->assertNotNull($m);
        $this->assertEquals('blog-post', $m->xmlRootName);
        $this->assertCount(4, $m->xmlNamespaces);
        $this->assertArrayHasKey('', $m->xmlNamespaces);
        $this->assertEquals('http://example.com/namespace', $m->xmlNamespaces['']);
        $this->assertArrayHasKey('gd', $m->xmlNamespaces);
        $this->assertEquals('http://schemas.google.com/g/2005', $m->xmlNamespaces['gd']);
        $this->assertArrayHasKey('atom', $m->xmlNamespaces);
        $this->assertEquals('http://www.w3.org/2005/Atom', $m->xmlNamespaces['atom']);
        $this->assertArrayHasKey('dc', $m->xmlNamespaces);
        $this->assertEquals('http://purl.org/dc/elements/1.1/', $m->xmlNamespaces['dc']);

        $p = new PropertyMetadata($m->name, 'id');
        $p->type = array('name' => 'string', 'params' => array());
        $p->groups = array("comments", "post");
        $p->xmlElementCData = false;
        $this->assertEquals($p, $m->propertyMetadata['id']);

        $p = new PropertyMetadata($m->name, 'title');
        $p->type = array('name' => 'string', 'params' => array());
        $p->groups = array("comments", "post");
        $p->xmlNamespace = "http://purl.org/dc/elements/1.1/";
        $this->assertEquals($p, $m->propertyMetadata['title']);

        $p = new PropertyMetadata($m->name, 'createdAt');
        $p->type = array('name' => 'DateTime', 'params' => array());
        $p->xmlAttribute = true;
        $this->assertEquals($p, $m->propertyMetadata['createdAt']);

        $p = new PropertyMetadata($m->name, 'published');
        $p->type = array('name' => 'boolean', 'params' => array());
        $p->serializedName = 'is_published';
        $p->xmlAttribute = true;
        $p->groups = array("post");
        $this->assertEquals($p, $m->propertyMetadata['published']);

        $p = new PropertyMetadata($m->name, 'etag');
        $p->type = array('name' => 'string', 'params' => array());
        $p->xmlAttribute = true;
        $p->groups = array("post");
        $p->xmlNamespace = "http://schemas.google.com/g/2005";
        $this->assertEquals($p, $m->propertyMetadata['etag']);

        $p = new PropertyMetadata($m->name, 'comments');
        $p->type = array('name' => 'ArrayCollection', 'params' => array(array('name' => 'SignNow\Serializer\Tests\Fixtures\Comment', 'params' => array())));
        $p->xmlCollection = true;
        $p->xmlCollectionInline = true;
        $p->xmlEntryName = 'comment';
        $p->groups = array("comments");
        $this->assertEquals($p, $m->propertyMetadata['comments']);

        $p = new PropertyMetadata($m->name, 'author');
        $p->type = array('name' => 'SignNow\Serializer\Tests\Fixtures\Author', 'params' => array());
        $p->groups = array("post");
        $p->xmlNamespace = 'http://www.w3.org/2005/Atom';
        $this->assertEquals($p, $m->propertyMetadata['author']);

        $m = $this->getDriver()->loadMetadataForClass(new ReflectionClass('SignNow\Serializer\Tests\Fixtures\Price'));
        $this->assertNotNull($m);

        $p = new PropertyMetadata($m->name, 'price');
        $p->type = array('name' => 'float', 'params' => array());
        $p->xmlValue = true;
        $this->assertEquals($p, $m->propertyMetadata['price']);
    }

    public function testXMLListAbsentNode()
    {
        $m = $this->getDriver()->loadMetadataForClass(new ReflectionClass('SignNow\Serializer\Tests\Fixtures\ObjectWithAbsentXmlListNode'));

        $this->assertArrayHasKey('absent', $m->propertyMetadata);
        $this->assertArrayHasKey('present', $m->propertyMetadata);
        $this->assertArrayHasKey('skipDefault', $m->propertyMetadata);

        $this->assertTrue($m->propertyMetadata['absent']->xmlCollectionSkipWhenEmpty);
        $this->assertTrue($m->propertyMetadata['skipDefault']->xmlCollectionSkipWhenEmpty);
        $this->assertFalse($m->propertyMetadata['present']->xmlCollectionSkipWhenEmpty);
    }

    public function testVirtualProperty()
    {
        $m = $this->getDriver()->loadMetadataForClass(new ReflectionClass('SignNow\Serializer\Tests\Fixtures\ObjectWithVirtualProperties'));

        $this->assertArrayHasKey('existField', $m->propertyMetadata);
        $this->assertArrayHasKey('virtualValue', $m->propertyMetadata);
        $this->assertArrayHasKey('virtualSerializedValue', $m->propertyMetadata);
        $this->assertArrayHasKey('typedVirtualProperty', $m->propertyMetadata);

        $this->assertEquals($m->propertyMetadata['virtualSerializedValue']->serializedName, 'test', 'Serialized name is missing');

        $p = new VirtualPropertyMetadata($m->name, 'virtualValue');
        $p->getter = 'getVirtualValue';

        $this->assertEquals($p, $m->propertyMetadata['virtualValue']);
    }

    public function testXmlKeyValuePairs()
    {
        $m = $this->getDriver()->loadMetadataForClass(new ReflectionClass('SignNow\Serializer\Tests\Fixtures\ObjectWithXmlKeyValuePairs'));

        $this->assertArrayHasKey('array', $m->propertyMetadata);
        $this->assertTrue($m->propertyMetadata['array']->xmlKeyValuePairs);
    }

    public function testExpressionVirtualPropertyWithExcludeAll()
    {
        $a = new ObjectWithExpressionVirtualPropertiesAndExcludeAll();
        $m = $this->getDriver()->loadMetadataForClass(new ReflectionClass($a));
    
        $this->assertArrayHasKey('virtualValue', $m->propertyMetadata);

        $p = new ExpressionPropertyMetadata($m->name, 'virtualValue', 'object.getVirtualValue()');
        $this->assertEquals($p, $m->propertyMetadata['virtualValue']);
    }

    public function testVirtualPropertyWithExcludeAll()
    {
        $a = new ObjectWithVirtualPropertiesAndExcludeAll();
        $m = $this->getDriver()->loadMetadataForClass(new ReflectionClass($a));

        $this->assertArrayHasKey('virtualValue', $m->propertyMetadata);

        $p = new VirtualPropertyMetadata($m->name, 'virtualValue');
        $p->getter = 'getVirtualValue';

        $this->assertEquals($p, $m->propertyMetadata['virtualValue']);
    }

    public function testReadOnlyDefinedBeforeGetterAndSetter()
    {
        $m = $this->getDriver()->loadMetadataForClass(new ReflectionClass('SignNow\Serializer\Tests\Fixtures\AuthorReadOnly'));

        $this->assertNotNull($m);
    }

    public function testExpressionVirtualProperty()
    {
        /** @var $m ClassMetadata */
        $m = $this->getDriver()->loadMetadataForClass(new ReflectionClass('SignNow\Serializer\Tests\Fixtures\AuthorExpressionAccess'));

        $keys = array_keys($m->propertyMetadata);
        $this->assertEquals(['firstName', 'lastName', 'id'], $keys);
    }

    public function testLoadDiscriminator()
    {
        /** @var $m ClassMetadata */
        $m = $this->getDriver()->loadMetadataForClass(new ReflectionClass('SignNow\Serializer\Tests\Fixtures\Discriminator\Vehicle'));

        $this->assertNotNull($m);
        $this->assertEquals('type', $m->discriminatorFieldName);
        $this->assertEquals($m->name, $m->discriminatorBaseClass);
        $this->assertEquals(
            array(
                'car' => 'SignNow\Serializer\Tests\Fixtures\Discriminator\Car',
                'moped' => 'SignNow\Serializer\Tests\Fixtures\Discriminator\Moped',
            ),
            $m->discriminatorMap
        );
    }

    public function testLoadDiscriminatorWhenParentIsInDiscriminatorMap()
    {
        /** @var ClassMetadata $m */
        $m = $this->getDriver()->loadMetadataForClass(new ReflectionClass('SignNow\Serializer\Tests\Fixtures\Discriminator\Post'));

        self::assertNotNull($m);
        self::assertEquals('type', $m->discriminatorFieldName);
        self::assertEquals($m->name, $m->discriminatorBaseClass);
        self::assertEquals(
            [
                'post' => 'SignNow\Serializer\Tests\Fixtures\Discriminator\Post',
                'image_post' => 'SignNow\Serializer\Tests\Fixtures\Discriminator\ImagePost',
            ],
            $m->discriminatorMap
        );
    }

    public function testLoadXmlDiscriminator()
    {
        /** @var $m ClassMetadata */
        $m = $this->getDriver()->loadMetadataForClass(new ReflectionClass(ObjectWithXmlAttributeDiscriminatorParent::class));

        $this->assertNotNull($m);
        $this->assertEquals('type', $m->discriminatorFieldName);
        $this->assertEquals($m->name, $m->discriminatorBaseClass);
        $this->assertEquals(
            array(
                'child' => ObjectWithXmlAttributeDiscriminatorChild::class,
            ),
            $m->discriminatorMap
        );
        $this->assertTrue($m->xmlDiscriminatorAttribute);
        $this->assertFalse($m->xmlDiscriminatorCData);
    }

    public function testLoadXmlDiscriminatorWithNamespaces()
    {
        /** @var $m ClassMetadata */
        $m = $this->getDriver()->loadMetadataForClass(new ReflectionClass(ObjectWithXmlNamespaceDiscriminatorParent::class));

        $this->assertNotNull($m);
        $this->assertEquals('type', $m->discriminatorFieldName);
        $this->assertEquals($m->name, $m->discriminatorBaseClass);
        $this->assertEquals(
            array(
                'child' => ObjectWithXmlNamespaceDiscriminatorChild::class,
            ),
            $m->discriminatorMap
        );
        $this->assertEquals('http://example.com/', $m->xmlDiscriminatorNamespace);
        $this->assertFalse($m->xmlDiscriminatorAttribute);
    }

    public function testLoadXmlDiscriminatorWithAttributeNamespaces()
    {
        /** @var $m ClassMetadata */
        $m = $this->getDriver()->loadMetadataForClass(new ReflectionClass(ObjectWithXmlNamespaceAttributeDiscriminatorParent::class));

        $this->assertNotNull($m);
        $this->assertEquals('type', $m->discriminatorFieldName);
        $this->assertEquals($m->name, $m->discriminatorBaseClass);
        $this->assertEquals(
            array(
                'child' => ObjectWithXmlNamespaceAttributeDiscriminatorChild::class,
            ),
            $m->discriminatorMap
        );
        $this->assertEquals('http://example.com/', $m->xmlDiscriminatorNamespace);
        $this->assertTrue($m->xmlDiscriminatorAttribute);
    }

    public function testLoadDiscriminatorWithGroup()
    {
        /** @var $m ClassMetadata */
        $m = $this->getDriver()->loadMetadataForClass(new ReflectionClass('SignNow\Serializer\Tests\Fixtures\DiscriminatorGroup\Vehicle'));

        $this->assertNotNull($m);
        $this->assertEquals('type', $m->discriminatorFieldName);
        $this->assertEquals(array('foo'), $m->discriminatorGroups);
        $this->assertEquals($m->name, $m->discriminatorBaseClass);
        $this->assertEquals(
            array(
                'car' => 'SignNow\Serializer\Tests\Fixtures\DiscriminatorGroup\Car'
            ),
            $m->discriminatorMap
        );
    }

    public function testSkipWhenEmptyOption()
    {
        /** @var $m ClassMetadata */
        $m = $this->getDriver()->loadMetadataForClass(new ReflectionClass(ParentSkipWithEmptyChild::class));

        $this->assertNotNull($m);

        $this->assertInstanceOf(PropertyMetadata::class, $m->propertyMetadata['c']);
        $this->assertInstanceOf(PropertyMetadata::class, $m->propertyMetadata['d']);
        $this->assertInstanceOf(PropertyMetadata::class, $m->propertyMetadata['child']);
        $this->assertFalse($m->propertyMetadata['c']->skipWhenEmpty);
        $this->assertFalse($m->propertyMetadata['d']->skipWhenEmpty);
        $this->assertTrue($m->propertyMetadata['child']->skipWhenEmpty);
    }

    public function testLoadDiscriminatorSubClass()
    {
        /** @var $m ClassMetadata */
        $m = $this->getDriver()->loadMetadataForClass(new ReflectionClass('SignNow\Serializer\Tests\Fixtures\Discriminator\Car'));

        $this->assertNotNull($m);
        $this->assertNull($m->discriminatorValue);
        $this->assertNull($m->discriminatorBaseClass);
        $this->assertNull($m->discriminatorFieldName);
        $this->assertEquals(array(), $m->discriminatorMap);
    }

    public function testLoadDiscriminatorSubClassWhenParentIsInDiscriminatorMap()
    {
        /** @var ClassMetadata $m */
        $m = $this->getDriver()->loadMetadataForClass(new ReflectionClass('SignNow\Serializer\Tests\Fixtures\Discriminator\ImagePost'));

        self::assertNotNull($m);
        self::assertNull($m->discriminatorValue);
        self::assertNull($m->discriminatorBaseClass);
        self::assertNull($m->discriminatorFieldName);
        self::assertEquals([], $m->discriminatorMap);
    }

    public function testLoadXmlObjectWithNamespacesMetadata()
    {
        $m = $this->getDriver()->loadMetadataForClass(new ReflectionClass('SignNow\Serializer\Tests\Fixtures\ObjectWithXmlNamespaces'));
        $this->assertNotNull($m);
        $this->assertEquals('test-object', $m->xmlRootName);
        $this->assertEquals('http://example.com/namespace', $m->xmlRootNamespace);
        $this->assertCount(3, $m->xmlNamespaces);
        $this->assertArrayHasKey('', $m->xmlNamespaces);
        $this->assertEquals('http://example.com/namespace', $m->xmlNamespaces['']);
        $this->assertArrayHasKey('gd', $m->xmlNamespaces);
        $this->assertEquals('http://schemas.google.com/g/2005', $m->xmlNamespaces['gd']);
        $this->assertArrayHasKey('atom', $m->xmlNamespaces);
        $this->assertEquals('http://www.w3.org/2005/Atom', $m->xmlNamespaces['atom']);

        $p = new PropertyMetadata($m->name, 'title');
        $p->type = array('name' => 'string', 'params' => array());
        $p->xmlNamespace = "http://purl.org/dc/elements/1.1/";
        $this->assertEquals($p, $m->propertyMetadata['title']);

        $p = new PropertyMetadata($m->name, 'createdAt');
        $p->type = array('name' => 'DateTime', 'params' => array());
        $p->xmlAttribute = true;
        $this->assertEquals($p, $m->propertyMetadata['createdAt']);

        $p = new PropertyMetadata($m->name, 'etag');
        $p->type = array('name' => 'string', 'params' => array());
        $p->xmlAttribute = true;
        $p->xmlNamespace = "http://schemas.google.com/g/2005";
        $this->assertEquals($p, $m->propertyMetadata['etag']);

        $p = new PropertyMetadata($m->name, 'author');
        $p->type = array('name' => 'string', 'params' => array());
        $p->xmlAttribute = false;
        $p->xmlNamespace = "http://www.w3.org/2005/Atom";
        $this->assertEquals($p, $m->propertyMetadata['author']);

        $p = new PropertyMetadata($m->name, 'language');
        $p->type = array('name' => 'string', 'params' => array());
        $p->xmlAttribute = true;
        $p->xmlNamespace = "http://purl.org/dc/elements/1.1/";
        $this->assertEquals($p, $m->propertyMetadata['language']);
    }

    public function testMaxDepth()
    {
        $m = $this->getDriver()->loadMetadataForClass(new ReflectionClass('SignNow\Serializer\Tests\Fixtures\Node'));

        $this->assertEquals(2, $m->propertyMetadata['children']->maxDepth);
    }

    public function testPersonCData()
    {
        $m = $this->getDriver()->loadMetadataForClass(new ReflectionClass('SignNow\Serializer\Tests\Fixtures\Person'));

        $this->assertNotNull($m);
        $this->assertFalse($m->propertyMetadata['name']->xmlElementCData);
    }

    public function testXmlNamespaceInheritanceMetadata()
    {
        $m = $this->getDriver()->loadMetadataForClass(new ReflectionClass('SignNow\Serializer\Tests\Fixtures\SimpleClassObject'));
        $this->assertNotNull($m);
        $this->assertCount(3, $m->xmlNamespaces);
        $this->assertArrayHasKey('old_foo', $m->xmlNamespaces);
        $this->assertEquals('http://old.foo.example.org', $m->xmlNamespaces['old_foo']);
        $this->assertArrayHasKey('foo', $m->xmlNamespaces);
        $this->assertEquals('http://foo.example.org', $m->xmlNamespaces['foo']);
        $this->assertArrayHasKey('new_foo', $m->xmlNamespaces);
        $this->assertEquals('http://new.foo.example.org', $m->xmlNamespaces['new_foo']);
        $this->assertCount(3, $m->propertyMetadata);

        $p = new PropertyMetadata($m->name, 'foo');
        $p->type = array('name' => 'string', 'params' => array());
        $p->xmlNamespace = "http://old.foo.example.org";
        $p->xmlAttribute = true;
        $this->assertEquals($p, $m->propertyMetadata['foo']);

        $p = new PropertyMetadata($m->name, 'bar');
        $p->type = array('name' => 'string', 'params' => array());
        $p->xmlNamespace = "http://foo.example.org";
        $this->assertEquals($p, $m->propertyMetadata['bar']);

        $p = new PropertyMetadata($m->name, 'moo');
        $p->type = array('name' => 'string', 'params' => array());
        $p->xmlNamespace = "http://new.foo.example.org";
        $this->assertEquals($p, $m->propertyMetadata['moo']);


        $subm = $this->getDriver()->loadMetadataForClass(new ReflectionClass('SignNow\Serializer\Tests\Fixtures\SimpleSubClassObject'));
        $this->assertNotNull($subm);
        $this->assertCount(2, $subm->xmlNamespaces);
        $this->assertArrayHasKey('old_foo', $subm->xmlNamespaces);
        $this->assertEquals('http://foo.example.org', $subm->xmlNamespaces['old_foo']);
        $this->assertArrayHasKey('foo', $subm->xmlNamespaces);
        $this->assertEquals('http://better.foo.example.org', $subm->xmlNamespaces['foo']);
        $this->assertCount(3, $subm->propertyMetadata);

        $p = new PropertyMetadata($subm->name, 'moo');
        $p->type = array('name' => 'string', 'params' => array());
        $p->xmlNamespace = "http://better.foo.example.org";
        $this->assertEquals($p, $subm->propertyMetadata['moo']);

        $p = new PropertyMetadata($subm->name, 'baz');
        $p->type = array('name' => 'string', 'params' => array());
        $p->xmlNamespace = "http://foo.example.org";
        $this->assertEquals($p, $subm->propertyMetadata['baz']);

        $p = new PropertyMetadata($subm->name, 'qux');
        $p->type = array('name' => 'string', 'params' => array());
        $p->xmlNamespace = "http://new.foo.example.org";
        $this->assertEquals($p, $subm->propertyMetadata['qux']);

        $m->merge($subm);
        $this->assertNotNull($m);
        $this->assertCount(3, $m->xmlNamespaces);
        $this->assertArrayHasKey('old_foo', $m->xmlNamespaces);
        $this->assertEquals('http://foo.example.org', $m->xmlNamespaces['old_foo']);
        $this->assertArrayHasKey('foo', $m->xmlNamespaces);
        $this->assertEquals('http://better.foo.example.org', $m->xmlNamespaces['foo']);
        $this->assertArrayHasKey('new_foo', $m->xmlNamespaces);
        $this->assertEquals('http://new.foo.example.org', $m->xmlNamespaces['new_foo']);
        $this->assertCount(5, $m->propertyMetadata);

        $p = new PropertyMetadata($m->name, 'foo');
        $p->type = array('name' => 'string', 'params' => array());
        $p->xmlNamespace = "http://old.foo.example.org";
        $p->xmlAttribute = true;
        $p->class = 'SignNow\Serializer\Tests\Fixtures\SimpleClassObject';
        $this->assetMetadataEquals($p, $m->propertyMetadata['foo']);

        $p = new PropertyMetadata($m->name, 'bar');
        $p->type = array('name' => 'string', 'params' => array());
        $p->xmlNamespace = "http://foo.example.org";
        $p->class = 'SignNow\Serializer\Tests\Fixtures\SimpleClassObject';
        $this->assetMetadataEquals($p, $m->propertyMetadata['bar']);

        $p = new PropertyMetadata($m->name, 'moo');
        $p->type = array('name' => 'string', 'params' => array());
        $p->xmlNamespace = "http://better.foo.example.org";
        $this->assetMetadataEquals($p, $m->propertyMetadata['moo']);

        $p = new PropertyMetadata($m->name, 'baz');
        $p->type = array('name' => 'string', 'params' => array());
        $p->xmlNamespace = "http://foo.example.org";
        $this->assetMetadataEquals($p, $m->propertyMetadata['baz']);

        $p = new PropertyMetadata($m->name, 'qux');
        $p->type = array('name' => 'string', 'params' => array());
        $p->xmlNamespace = "http://new.foo.example.org";
        $this->assetMetadataEquals($p, $m->propertyMetadata['qux']);
    }

    private function assetMetadataEquals(PropertyMetadata $expected, PropertyMetadata $actual)
    {
        $expectedVars = get_object_vars($expected);
        $actualVars = get_object_vars($actual);

        $expectedReflection = (array)$expectedVars['reflection'];
        $actualReflection = (array)$actualVars['reflection'];

        // HHVM bug with class property
        unset($expectedVars['reflection'], $actualVars['reflection']);
        $this->assertEquals($expectedVars, $actualVars);

        // HHVM bug with class property
        if (isset($expectedReflection['info']) || isset($actualReflection['info'])) {
            $expectedReflection['class'] = $expectedReflection['info']['class'];
            $actualReflection['class'] = $actualReflection['info']['class'];
        }

        $this->assertEquals($expectedReflection, $actualReflection);
    }

    public function testHandlerCallbacks()
    {
        $m = $this->getDriver()->loadMetadataForClass(new ReflectionClass('SignNow\Serializer\Tests\Fixtures\ObjectWithHandlerCallbacks'));

        $this->assertEquals('toJson', $m->handlerCallbacks[GraphNavigator::DIRECTION_SERIALIZATION]['json']);
        $this->assertEquals('toXml', $m->handlerCallbacks[GraphNavigator::DIRECTION_SERIALIZATION]['xml']);
    }

    public function testExclusionIf()
    {
        $class = 'SignNow\Serializer\Tests\Fixtures\PersonSecret';
        $m = $this->getDriver()->loadMetadataForClass(new ReflectionClass($class));

        $p = new PropertyMetadata($class, 'name');
        $p->type = array('name' => 'string', 'params' => array());
        $this->assertEquals($p, $m->propertyMetadata['name']);

        $p = new PropertyMetadata($class, 'gender');
        $p->type = array('name' => 'string', 'params' => array());
        $p->excludeIf = "show_data('gender')";
        $this->assertEquals($p, $m->propertyMetadata['gender']);

        $p = new PropertyMetadata($class, 'age');
        $p->type = array('name' => 'string', 'params' => array());
        $p->excludeIf = "!(show_data('age'))";
        $this->assertEquals($p, $m->propertyMetadata['age']);
    }

    public function testExcludePropertyNoPublicAccessorException()
    {
        $first = $this->getDriver()->loadMetadataForClass(new ReflectionClass('SignNow\Serializer\Tests\Fixtures\ExcludePublicAccessor'));

        if ($this instanceof PhpDriverTest) {
            return;
        }
        $this->assertArrayHasKey('id', $first->propertyMetadata);
        $this->assertArrayNotHasKey('iShallNotBeAccessed', $first->propertyMetadata);
    }


    /**
     * @return DriverInterface
     */
    abstract protected function getDriver();
}
