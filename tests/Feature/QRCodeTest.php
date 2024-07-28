<?php

declare(strict_types=1);

use BaconQrCode\Renderer\Color\Rgb;
use Hennest\QRCode\Configuration\ColorScheme;
use Hennest\QRCode\Configuration\Dimension;
use Hennest\QRCode\Enums\Color;
use Hennest\QRCode\Exceptions\InvalidColorException;
use Hennest\QRCode\Exceptions\InvalidMarginException;
use Hennest\QRCode\Exceptions\InvalidSizeException;
use Hennest\QRCode\Services\QRCodeInterface;
use Illuminate\Support\Facades\Storage;

it('can generate qr code', function (): void {
    $qrcode = app(QRCodeInterface::class);

    expect($qrcode->generate('hello world')->toSvg())->toContain('svg')
        ->and((string) $qrcode->generate('hello world'))->toContain('svg');
});

it('can generate qr code with default render style if no custom options are provided', function (): void {
    $qrcode = app(QRCodeInterface::class);

    $generatedQrcode = $qrcode->generate(
        content: 'hello world',
    );

    expect($generatedQrcode->toSvg())->toContain(
        'svg',
        'width="300"',
        'height="300"',
        rbgToHex(Color::White->rbg()),
        rbgToHex(Color::Black->rbg()),
    );
});

it('Generating a QR code with less than minimum should throw an exception', function (): void {
    $qrcode = app(QRCodeInterface::class);

    expect(function () use ($qrcode): void {
        $qrcode->generate(
            content: 'hello world',
            dimension: new Dimension(
                size: 2,
            ),
        );
    })->toThrow(
        exception: InvalidSizeException::class,
        exceptionMessage: 'Size cannot be less than minimum'
    );
});

it('Generating a QR code with less than margin should throw an exception', function (): void {
    $qrcode = app(QRCodeInterface::class);

    expect(function () use ($qrcode): void {
        $qrcode->generate(
            content: 'hello world',
            dimension: new Dimension(
                margin: -1,
            ),
        );
    })->toThrow(
        exception: InvalidMarginException::class,
        exceptionMessage: 'Margin cannot be less than minimum'
    );
});

it('Generating a QR code with the same foreground and background color should throw an exception', function (): void {
    $qrcode = app(QRCodeInterface::class);

    expect(function () use ($qrcode): void {
        $qrcode->generate(
            content: 'hello world',
            colorScheme: new ColorScheme(
                foreground: Color::Black,
                background: Color::Black,
            )
        );
    })->toThrow(
        exception: InvalidColorException::class,
        exceptionMessage: 'Foreground and background colors cannot be the same'
    );
});

it('can generate qr code with custom render style if custom options are provided', function (): void {
    $qrcode = app(QRCodeInterface::class);

    $generatedQrcode = $qrcode->generate(
        content: 'hello world',
        dimension: new Dimension(
            size: 200,
            margin: 5
        ),
        colorScheme: $color = new ColorScheme(
            foreground: Color::White,
            background: Color::Teal,
        )
    );

    expect($generatedQrcode->toSvg())->toContain(
        'svg',
        'width="200"',
        'height="200"',
        'transform="translate(5,5)"',
        rbgToHex($color->foreground()->rbg()),
        rbgToHex($color->background()->rbg()),
    );
});

it('can store qrcode using default config disk', function (): void {
    Storage::fake('public');

    $qrcode = app(QRCodeInterface::class);

    $generatedQrcode = $qrcode->generate(
        content: 'hello world',
    );

    expect($generatedQrcode->toImage('qr-code.svg'))->toContain(
        'svg',
    );

    Storage::disk('public')->assertExists('qr-code.svg');
});

it('can store qrcode using custom config disk', function (): void {
    Storage::fake('custom');

    $qrcode = app(QRCodeInterface::class);

    $generatedQrcode = $qrcode->generate(
        content: 'hello world',
    );

    expect($generatedQrcode->toImage('qr-code.svg', 'custom'))->toContain(
        'svg',
    );

    Storage::disk('custom')->assertExists('qr-code.svg');
});

function rbgToHex(Rgb $rgb): string
{
    return sprintf("#%02x%02x%02x", $rgb->getRed(), $rgb->getGreen(), $rgb->getBlue());
}
