<?php

namespace Signnow\Serializer\Builder;

use Doctrine\Common\Annotations\Reader;
use Signnow\Serializer\Metadata\Driver\AnnotationDriver;
use Signnow\Serializer\Metadata\Driver\XmlDriver;
use Signnow\Serializer\Metadata\Driver\YamlDriver;
use Metadata\Driver\DriverChain;
use Metadata\Driver\FileLocator;

class DefaultDriverFactory implements DriverFactoryInterface
{
    public function createDriver(array $metadataDirs, Reader $annotationReader)
    {
        if (!empty($metadataDirs)) {
            $fileLocator = new FileLocator($metadataDirs);

            return new DriverChain(array(
                new YamlDriver($fileLocator),
                new XmlDriver($fileLocator),
                new AnnotationDriver($annotationReader),
            ));
        }

        return new AnnotationDriver($annotationReader);
    }
}
