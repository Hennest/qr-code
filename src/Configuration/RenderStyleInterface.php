<?php

declare(strict_types=1);

namespace Hennest\QRCode\Configuration;

interface RenderStyleInterface
{
    public function apply(Dimension|null $dimension = null, ColorScheme|null $colorScheme = null): void;
}
