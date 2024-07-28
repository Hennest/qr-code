<?php

declare(strict_types=1);

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
            'size' => 300,
            /**
             * QR Code renderer margin
             */
            'margin' => 4,
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
