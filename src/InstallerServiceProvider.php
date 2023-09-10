<?php

namespace AbnDevs\Installer;

use AbnDevs\Installer\Http\Middleware\InstallationMiddleware;
use AbnDevs\Installer\Http\Middleware\RedirectIfInstalledMiddleware;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Http\Kernel;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class InstallerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('installer')
            ->hasConfigFile()
            ->hasViews()
            ->hasAssets()
            ->hasRoute('web');
    }

    /**
     * @throws BindingResolutionException
     */
    public function bootingPackage()
    {
        parent::bootingPackage();

        $this->app['router']->aliasMiddleware('install', InstallationMiddleware::class);
        $this->app['router']->aliasMiddleware('installed', RedirectIfInstalledMiddleware::class);

        $kernel = $this->app->make(Kernel::class);
        $kernel->prependMiddlewareToGroup('web', InstallationMiddleware::class);
    }
}
