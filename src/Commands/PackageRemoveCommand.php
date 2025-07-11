<?php

namespace Actcmsvn\DevTool\Commands;

use Actcmsvn\Base\Facades\BaseHelper;
use Actcmsvn\Base\Supports\Helper;
use Actcmsvn\DevTool\Helper as HelperDevTool;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;

#[AsCommand('cms:package:remove', 'Remove a package in the /platform/packages directory.')]
class PackageRemoveCommand extends Command implements PromptsForMissingInput
{
    public function handle(): int
    {
        if (! preg_match('/^[a-z0-9\-]+$/i', $this->argument('name'))) {
            $this->components->error('Only alphabetic characters are allowed.');

            return self::FAILURE;
        }

        $package = strtolower($this->argument('name'));
        $location = package_path($package);

        if (! $this->laravel['files']->isDirectory($location)) {
            $this->components->error('This package is not existed!');

            return self::FAILURE;
        }

        $this->processRemove($package, $location);

        return self::SUCCESS;
    }

    protected function processRemove(string $package, string $location): bool
    {
        $migrations = [];
        foreach (BaseHelper::scanFolder(
            HelperDevTool::joinPaths([$location, 'database', 'migrations'])
        ) as $file) {
            $migrations[] = pathinfo($file, PATHINFO_FILENAME);
        }

        DB::table('migrations')->whereIn('migration', $migrations)->delete();

        $this->laravel['files']->deleteDirectory($location);

        Helper::removeModuleFiles($package);

        $this->call('cache:clear');

        $this->components->info('Removed package files successfully!');

        $this->components->info(sprintf('Remove <comment>"actcmsvn/%s": "*@dev"</comment> to composer.json then run <comment>composer update</comment> to remove this package!', $package));

        return true;
    }

    protected function configure(): void
    {
        $this->addArgument('name', InputArgument::REQUIRED, 'The package name');
    }
}
