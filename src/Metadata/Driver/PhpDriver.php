<?php

namespace Signnow\Serializer\Metadata\Driver;

use Signnow\Serializer\Exception\RuntimeException;
use Signnow\Serializer\Metadata\ClassMetadata;
use Metadata\Driver\AbstractFileDriver;

class PhpDriver extends AbstractFileDriver
{
    protected function loadMetadataFromFile(\ReflectionClass $class, $file): ?ClassMetadata
    {
        $metadata = require $file;

        if (!$metadata instanceof ClassMetadata) {
            throw new RuntimeException(sprintf('The file %s was expected to return an instance of ClassMetadata, but returned %s.', $file, json_encode($metadata)));
        }
        if ($metadata->name !== $class->name) {
            throw new RuntimeException(sprintf('The file %s was expected to return metadata for class %s, but instead returned metadata for class %s.', $class->name, $metadata->name));
        }

        return $metadata;
    }

    protected function getExtension(): string
    {
        return 'php';
    }
}
