<?php
declare(strict_types=1);

namespace ExtendsFramework\Serializer\Mapper\Exception;

use ExtendsFramework\Serializer\Mapper\MapperException;
use InvalidArgumentException;

class ClassNotExists extends InvalidArgumentException implements MapperException
{
    /**
     * ClassNotExists constructor.
     *
     * @param string $className
     */
    public function __construct(string $className)
    {
        parent::__construct(sprintf(
            'Class with name "%s" does not exist and can not be added to the mapper.',
            $className
        ));
    }
}
