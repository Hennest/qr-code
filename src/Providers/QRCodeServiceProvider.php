<?php

declare(strict_types=1);

namespace Hennest\QRCode\Providers;

use BaconQrCode\Encoder\Encoder;
use BaconQrCode\Renderer\Image\ImageBackEndInterface;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererInterface;
use Hennest\QRCode\Assembler\QRCodeAssembler;
use Hennest\QRCode\Assembler\QRCodeAssemblerInterface;
use Hennest\QRCode\Configuration\ColorScheme;
use Hennest\QRCode\Configuration\Dimension;
use Hennest\QRCode\Configuration\RenderStyle;
use Hennest\QRCode\Configuration\RenderStyleInterface;
use Hennest\QRCode\Enums\Color;
use Hennest\QRCode\Enums\HasRGB;
use Hennest\QRCode\Services\QRCode;
use Hennest\QRCode\Services\QRCodeInterface;
use Illuminate\Support\ServiceProvider;

final class QRCodeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/qr-code.php',
            'qr-code'
        );

        /**
         * @var array{
         *     encoding: string|null,
         *     qr-code: class-string<QRCodeInterface>|null,
         *     assembler: class-string<QRCodeAssemblerInterface>|null,
         *     assembler: array{
         *          assembler: class-string<QRCodeAssemblerInterface>|null,
         *          disk: string|null,
         *     },
         *     renderer: array{
         *          renderer: class-string<RendererInterface>|null,
         *          backend: class-string<ImageBackEndInterface>|null,
         *           style: array{
         *               size: string|null,
         *               margin: string|null,
         *           },
         *     }
         * } $config
         */
        $config = config('qr-code');

        $this->app->singleton(
            abstract: QRCodeInterface::class,
            concrete: $config['qr-code'] ?? QRCode::class
        );

        $this->app->when(QRCode::class)
            ->needs('$encoding')
            ->give($config['encoding'] ?? Encoder::DEFAULT_BYTE_MODE_ECODING);

        $this->app->singleton(
            abstract: RendererInterface::class,
            concrete: $config['renderer']['renderer'] ?? ImageRenderer::class
        );

        $this->app->singleton(
            abstract: RenderStyleInterface::class,
            concrete: RenderStyle::class
        );

        $this->app->when(Dimension::class)
            ->needs('$size')
            ->give($config['renderer']['style']['size'] ?? '300');

        $this->app->when(Dimension::class)
            ->needs('$margin')
            ->give($config['renderer']['style']['margin'] ?? '4');

        $this->app->singleton(
            abstract: ColorScheme::class,
            concrete: function () use ($config) {
                /**
                 * @var array{
                 *     renderer: array{
                 *          style: array{
                 *              color: array{
                 *                  foreground: HasRGB|null,
                 *                  background: HasRGB|null,
                 *              }
                 *          },
                 *     }
                 * } $config
                 */
                return new ColorScheme(
                    foreground: $config['renderer']['style']['color']['foreground'] ?? Color::Black,
                    background: $config['renderer']['style']['color']['background'] ?? Color::White,
                );
            }
        );

        $this->app->singleton(
            abstract: ImageBackEndInterface::class,
            concrete: $config['renderer']['backend'] ?? SvgImageBackEnd::class
        );

        $this->app->singleton(
            abstract: QRCodeAssemblerInterface::class,
            concrete: $config['assembler']['assembler'] ?? QRCodeAssembler::class
        );

        $this->app->when(QRCodeAssembler::class)
            ->needs('$disk')
            ->give($config['assembler']['disk'] ?? 'public');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/qr-code.php' => config_path('qr-code.php'),
        ], 'qr-code-config');
    }
}
