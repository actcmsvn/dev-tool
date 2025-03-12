<?php

namespace ACTCMS\DevTool\Providers;

use ACTCMS\Base\Supports\ServiceProvider;

class DevToolServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (version_compare('1.3.0', get_core_version(), '>')) {
            return;
        }

        $this->app->register(CommandServiceProvider::class);
    }
}
