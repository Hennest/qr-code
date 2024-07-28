<?php

declare(strict_types=1);

namespace Hennest\QRCode\Configuration;

use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;

final readonly class RenderStyle implements RenderStyleInterface
{
    public function __construct(
        private Dimension $dimension,
        private ColorScheme $color
    ) {
    }

    public function apply(Dimension|null $dimension = null, ColorScheme|null $colorScheme = null): void
    {
        $rendererStyle = fn (): RendererStyle => new RendererStyle(
            size: $dimension?->size() ?? $this->dimension->size(),
            margin: $dimension?->margin() ?? $this->dimension->margin(),
            fill: Fill::uniformColor(
                backgroundColor: $colorScheme?->background()?->rbg() ?? $this->color->background()->rbg(),
                foregroundColor: $colorScheme?->foreground()?->rbg() ?? $this->color->foreground()->rbg()
            )
        );

        app()->singleton(
            abstract: RendererStyle::class,
            concrete: $rendererStyle
        );
    }
}
