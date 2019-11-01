<?php
declare(strict_types=1);

namespace ExtendsFramework\Serializer\Framework\ServiceLocator\Factory;

use ExtendsFramework\Serializer\Mapper\MapperInterface;
use ExtendsFramework\ServiceLocator\ServiceLocatorInterface;
use PHPUnit\Framework\TestCase;

class MapperFactoryTest extends TestCase
{
    /**
     * Create service.
     *
     * Test that correct service will be created.
     *
     * @covers \ExtendsFramework\Serializer\Framework\ServiceLocator\Factory\MapperFactory::createService()
     */
    public function testCreateService(): void
    {
        $serviceLocator = $this->createMock(ServiceLocatorInterface::class);
        $serviceLocator
            ->method('getConfig')
            ->willReturn([
                MapperInterface::class => [
                    ClassStub::class => 'ClassStub',
                ],
            ]);

        /**
         * @var ServiceLocatorInterface $serviceLocator
         */
        $factory = new MapperFactory();
        $mapper = $factory->createService(MapperInterface::class, $serviceLocator);

        $this->assertSame(ClassStub::class, $mapper->toClassName('ClassStub'));
    }
}
