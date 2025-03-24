<?php

declare(strict_types=1);

namespace Flux\Console;

use Composer\InstalledVersions;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Attribute\AsCommand;
use function Laravel\Prompts\info;
use function Laravel\Prompts\multisearch;
use function Laravel\Prompts\search;
use function Laravel\Prompts\warning;

#[AsCommand(name: 'flux:publish')]
class PublishCommand extends Command
{
    protected $signature = 'flux:publish {components?*} {--multiple} {--all} {--force}';

    protected $description = 'Publish individual flux components.';

    protected array $fluxComponents = [
        'free' => [
            'Accent' => ['accent'],
            'Avatar' => ['avatar'],
            'Badge' => ['badge'],
            'Brand' => ['brand'],
            'Breadcrumbs' => ['breadcrumbs'],
            'Button' => ['button'],
            'Checkbox' => ['checkbox'],
            'Dropdown' => ['dropdown', 'menu', 'navmenu'],
            'Field' => ['fieldset', 'legend', 'field', 'label', 'description', 'error'],
            'Heading' => ['heading', 'subheading', 'text', 'link'],
            'Icon' => ['icon'],
            'Input' => ['input'],
            'Layout' => ['header', 'sidebar', 'aside', 'main', 'footer', 'container', 'brand', 'profile', 'spacer'],
            'Modal' => ['modal'],
            'Navbar' => ['navbar', 'navlist'],
            'Radio' => ['radio'],
            'Separator' => ['separator'],
            'Select' => ['select'],
            'Switch' => ['switch'],
            'Textarea' => ['textarea'],
            'Tooltip' => ['tooltip'],
            'Typography' => ['heading', 'subheading', 'text', 'link'],
        ],
        'pro' => [
            'Accordion' => ['accordion'],
            'Autocomplete' => ['autocomplete'],
            'Calendar' => ['calendar'],
            'Card' => ['card'],
            'Chart' => ['chart'],
            'Checkbox' => ['checkbox'],
            'Command' => ['command'],
            'Context' => ['context'],
            'Date picker' => ['date-picker'],
            'Editor' => ['editor'],
            'Radio' => ['radio'],
            'Select' => ['select'],
            'Tabs' => ['tabs','tab'],
            'Table' => ['table', 'pagination'],
            'Toast' => ['toast'],
        ],
    ];

    public function handle(): void
    {
        if ($this->option('all')) {
            $componentNames = $this->fluxComponents()->keys()->all();
        } elseif (count($this->argument('components')) > 0) {
            $componentNames = $this->fluxComponents()
                ->keys()
                ->filter(fn (string $component) => in_array(str($component)->lower(), array_map('strtolower', $this->argument('components'))))
                ->values()
                ->all();
        } elseif($this->option('multiple')) {
            $componentNames = multisearch(
                label: 'Which component would you like to publish?',
                options: fn (string $value) => $this->searchOptions($value),
            );
        } else {
            $componentNames = (array) search(
                label: 'Which component would you like to publish?',
                options: fn (string $value) => $this->searchOptions($value),
            );
        }

        (new Filesystem)->ensureDirectoryExists(resource_path('views/flux'));

        $components = $this->fluxComponents()->intersectByKeys(array_flip($componentNames))->values()->flatten()->unique()->all();

        foreach ($components as $component) {
            $this->publishComponent($component);
        }
    }

    protected function fluxComponents(): Collection
    {
        return collect($this->fluxComponents['free'])
            ->when($this->isFluxProInstalled(), fn (Collection $collection) => $collection->merge(
                $this->fluxComponents['pro'],
            ))
            ->sortKeys();
    }

    protected function isFluxProInstalled(): bool
    {
        return InstalledVersions::isInstalled('livewire/flux-pro');
    }

    protected function searchOptions(string $value): array
    {
        if ($value === '') {
            return $this->fluxComponents()->keys()->toArray();
        }

        return $this->fluxComponents()
            ->keys()
            ->filter(fn (string $component) => str($component)->lower()->startsWith(str($value)->lower()))
            ->values()
            ->all();
    }

    protected function publishComponent(string $component): void
    {
        $filesystem = (new Filesystem);

        $sourceAsDirectory = __DIR__.'/../../stubs/resources/views/flux/'.$component;
        $sourceAsFile = __DIR__.'/../../stubs/resources/views/flux/'.$component.'.blade.php';
        $sourceAsProDirectory = __DIR__.'/../../../flux-pro/stubs/resources/views/flux/'.$component;
        $sourceAsProFile = __DIR__.'/../../../flux-pro/stubs/resources/views/flux/'.$component.'.blade.php';

        $destinationAsDirectory = resource_path('views/flux/'.$component);
        $destinationAsFile = resource_path('views/flux/'.$component.'.blade.php');

        $destination = $filesystem->isDirectory($sourceAsDirectory) ? $this->publishDirectory($component, $sourceAsDirectory, $destinationAsDirectory) : null;

        if ($destination) {
            info('Published: ' . $destination);
        }

        $destination = $filesystem->isFile($sourceAsFile) ? $this->publishFile($component, $sourceAsFile, $destinationAsFile) : null;

        if ($destination) {
            info('Published: ' . $destination);
        }

        $destination = $filesystem->isDirectory($sourceAsProDirectory) ? $this->publishDirectory($component, $sourceAsProDirectory, $destinationAsDirectory) : null;

        if ($destination) {
            info('Published: ' . $destination);
        }

        $destination = $filesystem->isFile($sourceAsProFile) ? $this->publishFile($component, $sourceAsProFile, $destinationAsFile) : null;

        if ($destination) {
            info('Published: ' . $destination);
        }

    }

    protected function publishDirectory($component, $source, $destination): ?string
    {
        $filesystem = (new Filesystem);

        $filesystem->copyDirectory($source, $destination);

        return $destination;
    }

    protected function publishFile($component, $source, $destination): ?string
    {
        $filesystem = (new Filesystem);

        if ($filesystem->exists($destination) && !$this->option('force')) {
            warning("Skipping [{$component}]. File already exists: {$destination}");

            return null;
        }

        $filesystem->copy($source, $destination);

        return $destination;
    }
}
