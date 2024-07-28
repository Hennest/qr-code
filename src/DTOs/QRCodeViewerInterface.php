<?php

declare(strict_types=1);

namespace Hennest\QRCode\DTOs;

interface QRCodeViewerInterface
{
    public function toSvg(): string;

    public function toImage(string $filename, string $disk = null): bool|string;
}
