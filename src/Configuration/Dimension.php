<?php

declare(strict_types=1);

namespace Hennest\QRCode\Configuration;

use Hennest\QRCode\Exceptions\InvalidMarginException;
use Hennest\QRCode\Exceptions\InvalidSizeException;

final readonly class Dimension
{
    private const MINIMUM_SIZE = 30;

    private const MINIMUM_MARGIN = 0;

    /**
     * @throws InvalidSizeException
     * @throws InvalidMarginException
     */
    public function __construct(
        private int $size = 30,
        private int $margin = 4,
    ) {
        if ($size < self::MINIMUM_SIZE) {
            throw InvalidSizeException::cannotBeLessThanMinimum();
        }

        if ($margin < self::MINIMUM_MARGIN) {
            throw InvalidMarginException::cannotBeLessThanMinimum();
        }
    }

    public function size(): int
    {
        return $this->size;
    }

    public function margin(): int
    {
        return $this->margin;
    }
}
