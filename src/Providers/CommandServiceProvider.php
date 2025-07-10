<?php

namespace Actcmsvn\DevTool\Providers;

use Actcmsvn\Base\Supports\ServiceProvider;
use Actcmsvn\DevTool\Commands\LocaleCreateCommand;
use Actcmsvn\DevTool\Commands\LocaleRemoveCommand;
use Actcmsvn\DevTool\Commands\Make\ControllerMakeCommand;
use Actcmsvn\DevTool\Commands\Make\FormMakeCommand;
use Actcmsvn\DevTool\Commands\Make\ModelMakeCommand;
use Actcmsvn\DevTool\Commands\Make\PanelSectionMakeCommand;
use Actcmsvn\DevTool\Commands\Make\RequestMakeCommand;
use Actcmsvn\DevTool\Commands\Make\RouteMakeCommand;
use Actcmsvn\DevTool\Commands\Make\SettingControllerMakeCommand;
use Actcmsvn\DevTool\Commands\Make\SettingFormMakeCommand;
use Actcmsvn\DevTool\Commands\Make\SettingMakeCommand;
use Actcmsvn\DevTool\Commands\Make\SettingRequestMakeCommand;
use Actcmsvn\DevTool\Commands\Make\TableMakeCommand;
use Actcmsvn\DevTool\Commands\PackageCreateCommand;
use Actcmsvn\DevTool\Commands\PackageMakeCrudCommand;
use Actcmsvn\DevTool\Commands\PackageRemoveCommand;
use Actcmsvn\DevTool\Commands\PluginCreateCommand;
use Actcmsvn\DevTool\Commands\PluginMakeCrudCommand;
use Actcmsvn\DevTool\Commands\RebuildPermissionsCommand;
use Actcmsvn\DevTool\Commands\TestSendMailCommand;
use Actcmsvn\DevTool\Commands\ThemeCreateCommand;
use Actcmsvn\DevTool\Commands\WidgetCreateCommand;
use Actcmsvn\DevTool\Commands\WidgetRemoveCommand;
use Actcmsvn\PluginManagement\Providers\PluginManagementServiceProvider;
use Actcmsvn\Theme\Providers\ThemeServiceProvider;
use Actcmsvn\Widget\Providers\WidgetServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            TableMakeCommand::class,
            ControllerMakeCommand::class,
            RouteMakeCommand::class,
            RequestMakeCommand::class,
            FormMakeCommand::class,
            ModelMakeCommand::class,
            PackageCreateCommand::class,
            PackageMakeCrudCommand::class,
            PackageRemoveCommand::class,
            TestSendMailCommand::class,
            RebuildPermissionsCommand::class,
            LocaleRemoveCommand::class,
            LocaleCreateCommand::class,
        ]);

        if (version_compare(get_core_version(), '7.0.0', '>=')) {
            $this->commands([
                PanelSectionMakeCommand::class,
                SettingControllerMakeCommand::class,
                SettingRequestMakeCommand::class,
                SettingFormMakeCommand::class,
                SettingMakeCommand::class,
            ]);
        }

        if (class_exists(PluginManagementServiceProvider::class)) {
            $this->commands([
                PluginCreateCommand::class,
                PluginMakeCrudCommand::class,
            ]);
        }

        if (class_exists(ThemeServiceProvider::class)) {
            $this->commands([
                ThemeCreateCommand::class,
            ]);
        }

        if (class_exists(WidgetServiceProvider::class)) {
            $this->commands([
                WidgetCreateCommand::class,
                WidgetRemoveCommand::class,
            ]);
        }
    }
}
