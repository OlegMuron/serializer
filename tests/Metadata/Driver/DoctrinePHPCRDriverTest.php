<?php

namespace SignNow\Serializer\Tests\Metadata\Driver;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ODM\PHPCR\Configuration;
use Doctrine\ODM\PHPCR\DocumentManager;
use Doctrine\ODM\PHPCR\Mapping\Driver\AnnotationDriver as DoctrinePHPCRDriver;
use SignNow\Serializer\Metadata\Driver\AnnotationDriver;
use SignNow\Serializer\Metadata\Driver\DoctrinePHPCRTypeDriver;

class DoctrinePHPCRDriverTest extends \PHPUnit\Framework\TestCase
{
    public function getMetadata()
    {
        $refClass = new \ReflectionClass('SignNow\Serializer\Tests\Fixtures\DoctrinePHPCR\BlogPost');
        $metadata = $this->getDoctrinePHPCRDriver()->loadMetadataForClass($refClass);

        return $metadata;
    }

    public function testTypelessPropertyIsGivenTypeFromDoctrineMetadata()
    {
        $metadata = $this->getMetadata();
        $this->assertEquals(
            array('name' => 'DateTime', 'params' => array()),
            $metadata->propertyMetadata['createdAt']->type
        );
    }

    public function testSingleValuedAssociationIsProperlyHinted()
    {
        $metadata = $this->getMetadata();
        $this->assertEquals(
            array('name' => 'SignNow\Serializer\Tests\Fixtures\DoctrinePHPCR\Author', 'params' => array()),
            $metadata->propertyMetadata['author']->type
        );
    }

    public function testMultiValuedAssociationIsProperlyHinted()
    {
        $metadata = $this->getMetadata();

        $this->assertEquals(
            array('name' => 'ArrayCollection', 'params' => array(
                array('name' => 'SignNow\Serializer\Tests\Fixtures\DoctrinePHPCR\Comment', 'params' => array()))
            ),
            $metadata->propertyMetadata['comments']->type
        );
    }

    public function testTypeGuessByDoctrineIsOverwrittenByDelegateDriver()
    {
        $metadata = $this->getMetadata();

        // This would be guessed as boolean but we've overridden it to integer
        $this->assertEquals(
            array('name' => 'integer', 'params' => array()),
            $metadata->propertyMetadata['published']->type
        );
    }

    public function testNonDoctrineDocumentClassIsNotModified()
    {
        // Note: Using regular BlogPost fixture here instead of Doctrine fixture
        // because it has no Doctrine metadata.
        $refClass = new \ReflectionClass('SignNow\Serializer\Tests\Fixtures\BlogPost');

        $plainMetadata = $this->getAnnotationDriver()->loadMetadataForClass($refClass);
        $doctrineMetadata = $this->getDoctrinePHPCRDriver()->loadMetadataForClass($refClass);

        // Do not compare timestamps
        if (abs($doctrineMetadata->createdAt - $plainMetadata->createdAt) < 2) {
            $plainMetadata->createdAt = $doctrineMetadata->createdAt;
        }

        $this->assertEquals($plainMetadata, $doctrineMetadata);
    }

    protected function getDocumentManager()
    {
        $config = new Configuration();
        $config->setProxyDir(sys_get_temp_dir() . '/JMSDoctrineTestProxies');
        $config->setProxyNamespace('SignNow\Tests\Proxies');
        $config->setMetadataDriverImpl(
            new DoctrinePHPCRDriver(new AnnotationReader(), __DIR__ . '/../../Fixtures/DoctrinePHPCR')
        );

        $session = $this->getMockBuilder('PHPCR\SessionInterface')->getMock();

        return DocumentManager::create($session, $config);
    }

    public function getAnnotationDriver()
    {
        return new AnnotationDriver(new AnnotationReader());
    }

    protected function getDoctrinePHPCRDriver()
    {
        $registry = $this->getMockBuilder('Doctrine\Common\Persistence\ManagerRegistry')->getMock();
        $registry->expects($this->atLeastOnce())
            ->method('getManagerForClass')
            ->will($this->returnValue($this->getDocumentManager()));

        return new DoctrinePHPCRTypeDriver(
            $this->getAnnotationDriver(),
            $registry
        );
    }
}
