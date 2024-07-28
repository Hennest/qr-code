<?php

declare(strict_types=1);

namespace Hennest\QRCode\Services;

use BaconQrCode\Common\ErrorCorrectionLevel;
use BaconQrCode\Encoder\Encoder;
use BaconQrCode\Renderer\RendererInterface;
use Hennest\QRCode\Assembler\QRCodeAssemblerInterface;
use Hennest\QRCode\Configuration\ColorScheme;
use Hennest\QRCode\Configuration\Dimension;
use Hennest\QRCode\Configuration\RenderStyleInterface;
use Hennest\QRCode\DTOs\QRCodeViewerInterface;

final readonly class QRCode implements QRCodeInterface
{
    public function __construct(
        private QRCodeAssemblerInterface $QRCodeAssembler,
        private RenderStyleInterface $renderStyle,
        private string $encoding,
    ) {
    }

    public function generate(
        string $content,
        Dimension|null $dimension = null,
        ColorScheme|null $colorScheme = null
    ): QRCodeViewerInterface {
        $this->renderStyle->apply(
            dimension: $dimension,
            colorScheme: $colorScheme,
        );

        return $this->QRCodeAssembler->create(
            app(RendererInterface::class)->render(Encoder::encode(
                content: $content,
                ecLevel: ErrorCorrectionLevel::L(),
                encoding: $this->encoding,
            ))
        );
    }
}
