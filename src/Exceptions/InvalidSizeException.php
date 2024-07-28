<?php

declare(strict_types=1);

namespace Hennest\QRCode\Exceptions;

use Exception;

final class InvalidSizeException extends Exception
{
    public static function cannotBeLessThanMinimum(): self
    {
        return new self('Size cannot be less than minimum');
    }
}
