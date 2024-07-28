<?php

declare(strict_types=1);

namespace Hennest\QRCode\Exceptions;

use Exception;

final class InvalidMarginException extends Exception
{
    public static function cannotBeLessThanMinimum(): self
    {
        return new self('Margin cannot be less than minimum');
    }
}
