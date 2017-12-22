<?php
declare(strict_types=1);

namespace ExtendsFramework\Serializer\Framework\ServiceLocator\Loader;

use ExtendsFramework\Serializer\Framework\ServiceLocator\Factory\MapperFactory;
use ExtendsFramework\Serializer\Mapper\MapperInterface;
use ExtendsFramework\Serializer\Reflection\ReflectionSerializer;
use ExtendsFramework\Serializer\SerializerInterface;
use ExtendsFramework\ServiceLocator\Resolver\Factory\FactoryResolver;
use ExtendsFramework\ServiceLocator\Resolver\Reflection\ReflectionResolver;
use ExtendsFramework\ServiceLocator\ServiceLocatorInterface;
use PHPUnit\Framework\TestCase;

class SerializerConfigLoaderTest extends TestCase
{
    /**
     * Load.
     *
     * Test that correct config will be loaded.
     *
     * @covers \ExtendsFramework\Serializer\Framework\ServiceLocator\Loader\SerializerConfigLoader::load()
     */
    public function testLoad(): void
    {
        $loader = new SerializerConfigLoader();

        $this->assertSame([
            ServiceLocatorInterface::class => [
                FactoryResolver::class => [
                    MapperInterface::class => MapperFactory::class,
                ],
                ReflectionResolver::class => [
                    SerializerInterface::class => ReflectionSerializer::class,
                ],
            ],
        ], $loader->load());
    }
}
