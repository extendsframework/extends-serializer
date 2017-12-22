<?php
declare(strict_types=1);

namespace ExtendsFramework\Serializer\Framework\ServiceLocator\Loader;

use ExtendsFramework\Serializer\Framework\ServiceLocator\Factory\MapperFactory;
use ExtendsFramework\Serializer\Mapper\MapperInterface;
use ExtendsFramework\Serializer\Reflection\ReflectionSerializer;
use ExtendsFramework\Serializer\SerializerInterface;
use ExtendsFramework\ServiceLocator\Config\Loader\LoaderInterface;
use ExtendsFramework\ServiceLocator\Resolver\Factory\FactoryResolver;
use ExtendsFramework\ServiceLocator\Resolver\Reflection\ReflectionResolver;
use ExtendsFramework\ServiceLocator\ServiceLocatorInterface;

class SerializerConfigLoader implements LoaderInterface
{
    /**
     * @inheritDoc
     */
    public function load(): array
    {
        return [
            ServiceLocatorInterface::class => [
                FactoryResolver::class => [
                    MapperInterface::class => MapperFactory::class,
                ],
                ReflectionResolver::class => [
                    SerializerInterface::class => ReflectionSerializer::class,
                ],
            ],
        ];
    }
}
