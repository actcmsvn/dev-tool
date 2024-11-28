<?php

namespace ACTCMS\DevTool\Providers;

use ACTCMS\Base\Supports\ServiceProvider;
use ACTCMS\DevTool\Commands\LocaleCreateCommand;
use ACTCMS\DevTool\Commands\LocaleRemoveCommand;
use ACTCMS\DevTool\Commands\Make\ControllerMakeCommand;
use ACTCMS\DevTool\Commands\Make\FormMakeCommand;
use ACTCMS\DevTool\Commands\Make\ModelMakeCommand;
use ACTCMS\DevTool\Commands\Make\PanelSectionMakeCommand;
use ACTCMS\DevTool\Commands\Make\RequestMakeCommand;
use ACTCMS\DevTool\Commands\Make\RouteMakeCommand;
use ACTCMS\DevTool\Commands\Make\SettingControllerMakeCommand;
use ACTCMS\DevTool\Commands\Make\SettingFormMakeCommand;
use ACTCMS\DevTool\Commands\Make\SettingMakeCommand;
use ACTCMS\DevTool\Commands\Make\SettingRequestMakeCommand;
use ACTCMS\DevTool\Commands\Make\TableMakeCommand;
use ACTCMS\DevTool\Commands\PackageCreateCommand;
use ACTCMS\DevTool\Commands\PackageMakeCrudCommand;
use ACTCMS\DevTool\Commands\PackageRemoveCommand;
use ACTCMS\DevTool\Commands\PluginCreateCommand;
use ACTCMS\DevTool\Commands\PluginMakeCrudCommand;
use ACTCMS\DevTool\Commands\RebuildPermissionsCommand;
use ACTCMS\DevTool\Commands\TestSendMailCommand;
use ACTCMS\DevTool\Commands\ThemeCreateCommand;
use ACTCMS\DevTool\Commands\WidgetCreateCommand;
use ACTCMS\DevTool\Commands\WidgetRemoveCommand;

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

        if (class_exists(\ACTCMS\PluginManagement\Providers\PluginManagementServiceProvider::class)) {
            $this->commands([
                PluginCreateCommand::class,
                PluginMakeCrudCommand::class,
            ]);
        }

        if (class_exists(\ACTCMS\Theme\Providers\ThemeServiceProvider::class)) {
            $this->commands([
                ThemeCreateCommand::class,
            ]);
        }

        if (class_exists(\ACTCMS\Widget\Providers\WidgetServiceProvider::class)) {
            $this->commands([
                WidgetCreateCommand::class,
                WidgetRemoveCommand::class,
            ]);
        }
    }
}
