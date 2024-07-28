<?php

declare(strict_types=1);

namespace Hennest\QRCode\Tests;

use Hennest\QRCode\Providers\QRCodeServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Orchestra\Testbench\TestCase;

abstract class QrCodeServiceProviderTest extends TestCase
{
    /**
     * @param Application $app
     * @return array<int, class-string<ServiceProvider>>
     */
    protected function getPackageProviders($app): array
    {
        return [
            QRCodeServiceProvider::class,
        ];
    }
}
