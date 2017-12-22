<?php
declare(strict_types=1);

namespace ExtendsFramework\Serializer;

class ClassMapper implements ClassMapperInterface
{
    /**
     * Identifier to class name mapping.
     *
     * @var array
     */
    protected $mapping = [];

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
        return array_search($className, $this->mapping) ?: null;
    }

    /**
     * Add class name for identifier.
     *
     * @param string $className
     * @param string $identifier
     * @return ClassMapper
     */
    public function addMapping(string $className, string $identifier): ClassMapper
    {
        $this->mapping[$identifier] = $className;

        return $this;
    }
}
