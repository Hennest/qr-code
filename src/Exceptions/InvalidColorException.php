<?php

declare(strict_types=1);

namespace Hennest\QRCode\Exceptions;

use Exception;

final class InvalidColorException extends Exception
{
    public static function cannotBeTheSame(): self
    {
        return new self('Foreground and background colors cannot be the same');
    }
}
