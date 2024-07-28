# Qr Code Generator 

## Installation

You can install this library via Composer:

```bash
composer require hennest/qr-code
```

## Laravel Integration

This library comes with a Laravel service provider for easy integration. After installation, add the service provider to your `config/app.php` file:

```php
'providers' => [
    // Other Service Providers
    Hennest\QRCode\Providers\QRCodeServiceProvider::class,
],
```

### Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --tag=qr-code
```

This will create a `config/qr-code.php` file where you can customize the library settings.

## Usage

### Basic Usage

```php
use Hennest\QRCode\Enums\Color;
use Hennest\QRCode\Configuration\Dimension;
use Hennest\QRCode\Configuration\ColorScheme;
use Hennest\QRCode\Services\QRCodeInterface;

class ExampleController
{
    public function __construct(
        private QRCodeInterface $qrCode
    ) {}

    public function example()
    {
        // Generate a QR code
        $qrCode = $this->qrCode->generate('https://example.com')->toSvg();
        
        // Generate a QR code with custom settings
        $qrCode = $this->qrCode->generate(
            content: 'https://example.com',
            dimension: new Dimension(
                size: 300, 
                margin: 300
            ),
            colorScheme: new ColorScheme(
                foreground: Color::Black,
                background: Color::White
            ) 
        )->toSvg();
        
        // Save a QR code to a file
        $this->qrCode->generate('https://example.com')->toImage('path/to/file.svg');
    }
    
    public function anotherExample()
    {
        // Generate a QR code
        $qrCode = app(QRCodeInterface::class)->generate('https://example.com')->toSvg();
        
        // Generate a QR code with custom settings
        $qrCode = app(QRCodeInterface::class)->generate(
            content: 'https://example.com',
            dimension: new Dimension(
                size: 300, 
                margin: 300
            ),
            colorScheme: new ColorScheme(
                foreground: Color::Black,
                background: Color::White
            ) 
        )->toSvg();
        
        // Save a QR code to a file
        $qrCode = app(QRCodeInterface::class)->generate('https://example.com')->toImage('path/to/file.svg');
    }
}
```

### Configuration Options

The `config/qr-code.php` file allows you to customize various aspects of the library. Here's a breakdown of the available options:

```php
return [
    /**
     * QR Code assembler configuration
     */
    'assembler' => [
        /**
         * QR Code assembler
         */
        'assembler' => Hennest\QRCode\Assembler\QRCodeAssembler::class,
        /**
         * QR Code assembler disk
         */
        'disk' => 'public',
    ],
    /**
     * QR Code default encoding
     */
    'encoding' => BaconQrCode\Encoder\Encoder::DEFAULT_BYTE_MODE_ECODING,
    /**
     * QR Code service
     */
    'qr-code' => Hennest\QRCode\Services\QRCode::class,
    /**
     * QR Code renderer configuration
     */
    'renderer' => [
        /**
         * QR Code renderer
         */
        'renderer' => BaconQrCode\Renderer\ImageRenderer::class,
        /**
         * QR Code renderer backend
         */
        'backend' => BaconQrCode\Renderer\Image\SvgImageBackEnd::class,
        /**
         * QR Code renderer default style configuration
         */
        'style' => [
            /**
             * QR Code renderer style
             */
            'style' => Hennest\QRCode\Configuration\RenderStyle::class,
            /**
             * QR Code renderer size
             */
            'size' => env('QR_CODE_SIZE', 300),
            /**
             * QR Code renderer margin
             */
            'margin' => env('QR_CODE_MARGIN', 4),
            /**
             * QR Code renderer color
             */
            'color' => [
                /**
                 * QR Code renderer foreground color
                 */
                'foreground' => Hennest\QRCode\Enums\Color::Black,
                /**
                 * QR Code renderer background color
                 */
                'background' => Hennest\QRCode\Enums\Color::White,
            ],
        ],
    ],
];
```

#### Key Configuration Options:

- `assembler.disk`: Set the default disk for saving QR codes.
- `renderer.style.size`: Set the default size for QR codes.
- `renderer.style.margin`: Set the default margin for QR codes.
- `renderer.style.color.foreground`: Set the default foreground color for QR codes.
- `renderer.style.color.background`: Set the default background color for QR codes.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This library is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
