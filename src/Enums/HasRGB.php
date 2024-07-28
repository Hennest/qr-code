<?php

declare(strict_types=1);

namespace Hennest\QRCode\Enums;

use BaconQrCode\Renderer\Color\Rgb;

interface HasRGB extends Colorable
{
    public function rbg(): Rgb;
}
