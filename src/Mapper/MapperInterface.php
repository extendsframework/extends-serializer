<?php
declare(strict_types=1);

namespace ExtendsFramework\Serializer\Mapper;

interface MapperInterface
{
    /**
     * Get class name for identifier.
     *
     * @param string $identifier
     * @return string|null
     */
    public function toClassName(string $identifier): ?string;

    /**
     * Get identifier for class name.
     *
     * @param string $className
     * @return string|null
     */
    public function fromClassName(string $className): ?string;
}
