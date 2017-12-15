<?php
declare(strict_types=1);

namespace ExtendsFramework\Serializer;

class SerializedObject implements SerializedObjectInterface
{
    /**
     * Serialized object class name.
     *
     * @var string
     */
    protected $className;

    /**
     * Serialized object data.
     *
     * @var array
     */
    protected $data;

    /**
     * SerializedObject constructor.
     *
     * @param string $className
     * @param array  $data
     */
    public function __construct(string $className, array $data)
    {
        $this->className = $className;
        $this->data = $data;
    }

    /**
     * @inheritDoc
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        return $this->data;
    }
}
