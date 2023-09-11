<?php
namespace Scm\PluginSampleTheming;


use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ScmSampleThemingProvider extends PackageServiceProvider
{

    const VIEW_BLADE_ROOT = 'ScmThemeTest';
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('scm-plugin-sample-theming')
        ;

        $package
            ->name('scm-plugin-sample-theming')

            ->hasViews(static::VIEW_BLADE_ROOT)
            ->hasRoute('web')
            ->hasAssets()
            ->hasMigration('create_scm_plugin_sample_inventory')
            ->hasInstallCommand(function(InstallCommand $command) {

                $command
                    ->publishAssets()
                ;
            })
            ->runsMigrations()
        ;
    }


    protected PluginLogic $plugin_logic;
    public function packageBooted()
    {
        $this->plugin_logic = new PluginLogic();
        $this->plugin_logic->initialize();

        return $this;
    }

}
