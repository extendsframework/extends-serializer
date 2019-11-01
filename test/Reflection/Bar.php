<?php
declare(strict_types=1);

namespace ExtendsFramework\Serializer\Reflection;

class Bar
{
    /**
     * @var string
     */
    protected $qux;

    /**
     * @var Baz
     */
    protected $quux;

    /**
     * @param string $qux
     * @param Baz    $quux
     */
    public function __construct(string $qux, Baz $quux)
    {
        $this->qux = $qux;
        $this->quux = $quux;
    }
}
