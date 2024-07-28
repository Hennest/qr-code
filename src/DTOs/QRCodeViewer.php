<?php

declare(strict_types=1);

namespace Hennest\QRCode\DTOs;

use Illuminate\Support\Facades\Storage;

final readonly class QRCodeViewer implements QRCodeViewerInterface
{
    public function __construct(
        private string $qrCode,
        private string|null $disk = null
    ) {
    }

    public function toSvg(): string
    {
        return trim(substr($this->qrCode, (int) strpos($this->qrCode, "\n")));
    }

    public function toImage(string $filename, string $disk = null): bool|string
    {
        $storage = Storage::disk($disk ?? $this->disk);

        $storage->put(
            path: $filename,
            contents: $this->toSvg()
        );

        return $storage->get(
            path: $filename,
        );
    }

    public function __toString(): string
    {
        return $this->toSvg();
    }
}
