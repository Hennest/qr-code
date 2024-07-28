<?php

declare(strict_types=1);

namespace Hennest\QRCode\Enums;

use BaconQrCode\Renderer\Color\Rgb;

enum Color: string implements Colorable, HasRGB
{
    case Black = 'black';

    case White = 'white';

    case Marron = 'marron';

    case Olive = 'olive';

    case Navy = 'navy';

    case Teal = 'teal';

    case Silver = 'silver';

    case Grey = 'grey';

    public function rbg(): Rgb
    {
        return match ($this) {
            self::Black => new Rgb(0, 0, 0),
            self::White => new Rgb(255, 255, 255),
            self::Marron => new Rgb(128, 0, 0),
            self::Olive => new Rgb(128, 128, 0),
            self::Navy => new Rgb(0, 0, 128),
            self::Teal => new Rgb(0, 128, 128),
            self::Silver => new Rgb(192, 192, 192),
            self::Grey => new Rgb(99, 99, 99),
        };
    }
}
