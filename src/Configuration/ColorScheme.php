<?php

declare(strict_types=1);

namespace Hennest\QRCode\Configuration;

use Hennest\QRCode\Enums\HasRGB;
use Hennest\QRCode\Exceptions\InvalidColorException;

final readonly class ColorScheme
{
    /**
     * @throws InvalidColorException
     */
    public function __construct(
        private HasRGB $foreground,
        private HasRGB $background,
    ) {
        if ($foreground === $background) {
            throw InvalidColorException::cannotBeTheSame();
        }
    }

    public function foreground(): HasRGB
    {
        return $this->foreground;
    }

    public function background(): HasRGB
    {
        return $this->background;
    }
}
