<?php

declare(strict_types=1);

namespace Hennest\QRCode\Services;

use Hennest\QRCode\Configuration\ColorScheme;
use Hennest\QRCode\Configuration\Dimension;
use Hennest\QRCode\DTOs\QRCodeViewerInterface;

interface QRCodeInterface
{
    public function generate(
        string $content,
        Dimension|null $dimension = null,
        ColorScheme|null $colorScheme = null
    ): QRCodeViewerInterface;
}
