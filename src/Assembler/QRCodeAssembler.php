<?php

declare(strict_types=1);

namespace Hennest\QRCode\Assembler;

use Hennest\QRCode\DTOs\QRCodeViewer;
use Hennest\QRCode\DTOs\QRCodeViewerInterface;

final readonly class QRCodeAssembler implements QRCodeAssemblerInterface
{
    public function __construct(private string $disk)
    {
    }

    public function create(string $content): QRCodeViewerInterface
    {
        return new QRCodeViewer(
            qrCode: $content,
            disk: $this->disk
        );
    }
}
