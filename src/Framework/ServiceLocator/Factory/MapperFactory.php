<?php
declare(strict_types=1);

namespace ExtendsFramework\Serializer\Framework\ServiceLocator\Factory;

use ExtendsFramework\Serializer\Mapper\Mapper;
use ExtendsFramework\Serializer\Mapper\MapperException;
use ExtendsFramework\Serializer\Mapper\MapperInterface;
use ExtendsFramework\ServiceLocator\Resolver\Factory\ServiceFactoryInterface;
use ExtendsFramework\ServiceLocator\ServiceLocatorInterface;

class MapperFactory implements ServiceFactoryInterface
{
    /**
     * @inheritDoc
     * @throws MapperException
     */
    public function createService(string $key, ServiceLocatorInterface $serviceLocator, array $extra = null): object
    {
        $config = $serviceLocator->getConfig();
        $config = $config[MapperInterface::class] ?? [];

        $mapper = new Mapper();
        foreach ($config as $className => $identifier) {
            $mapper->addMapping($className, $identifier);
        }

        return $mapper;
    }
}
