<?php
declare(strict_types=1);

namespace ExtendsFramework\Serializer\Mapper;

use ExtendsFramework\Serializer\Mapper\Exception\ClassNotExists;

class Mapper implements MapperInterface
{
    /**
     * Identifier to class name mapping.
     *
     * @var array
     */
    private $mapping = [];

    /**
     * @inheritDoc
     */
    public function toClassName(string $identifier): ?string
    {
        return $this->mapping[$identifier] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function fromClassName(string $className): ?string
    {
        return array_search($className, $this->mapping, true) ?: null;
    }

    /**
     * Add class name for identifier.
     *
     * @param string $className
     * @param string $identifier
     * @return Mapper
     * @throws MapperException
     */
    public function addMapping(string $className, string $identifier): Mapper
    {
        if (!class_exists($className)) {
            throw new ClassNotExists($className);
        }

        $this->mapping[$identifier] = $className;

        return $this;
    }
}
