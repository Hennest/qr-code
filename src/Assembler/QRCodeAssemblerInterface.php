<?php

declare(strict_types=1);

namespace Hennest\QRCode\Assembler;

use Hennest\QRCode\DTOs\QRCodeViewerInterface;

interface QRCodeAssemblerInterface
{
    public function create(string $content): QRCodeViewerInterface;
}
