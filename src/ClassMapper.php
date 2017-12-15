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
     * ClassMapper constructor.
     *
     * @param array|null $mapping
     */
    public function __construct(array $mapping = null)
    {
        $this->mapping = $mapping ?? [];
    }

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
}
