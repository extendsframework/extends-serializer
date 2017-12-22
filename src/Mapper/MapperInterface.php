<?php
declare(strict_types=1);

namespace ExtendsFramework\Serializer\Mapper;

interface MapperInterface
{
    /**
     * Get class name for identifier.
     *
     * @param string $identifier
     * @return null|string
     */
    public function toClassName(string $identifier): ?string;

    /**
     * Get identifier for class name.
     *
     * @param string $className
     * @return null|string
     */
    public function fromClassName(string $className): ?string;
}
