<?php
declare(strict_types=1);

namespace ExtendsFramework\Serializer;

use PHPUnit\Framework\TestCase;

class SerializedObjectTest extends TestCase
{
    /**
     * Get methods.
     *
     * Test that correct values will be returned.
     *
     * @covers \ExtendsFramework\Serializer\SerializedObject::__construct()
     * @covers \ExtendsFramework\Serializer\SerializedObject::getClass()
     * @covers \ExtendsFramework\Serializer\SerializedObject::getData()
     */
    public function testGetMethods(): void
    {
        $serializedObject = new SerializedObject('Foo\Bar', ['foo' => 'bar']);

        $this->assertSame('Foo\Bar', $serializedObject->getClass());
        $this->assertSame(['foo' => 'bar'], $serializedObject->getData());
    }
}
