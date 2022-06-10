<?php

namespace Signnow\Serializer\Metadata\Driver;

use Signnow\Serializer\Metadata\ClassMetadata;
use Metadata\Driver\DriverInterface;

class NullDriver implements DriverInterface
{
    public function loadMetadataForClass(\ReflectionClass $class): ?ClassMetadata
    {
        $classMetadata = new ClassMetadata($name = $class->name);
        $classMetadata->fileResources[] = $class->getFilename();

        return $classMetadata;
    }
}
