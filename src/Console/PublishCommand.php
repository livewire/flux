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
            'Button' => ['button'],
            'Dropdown' => ['dropdown', 'menu', 'navmenu'],
            'Icon' => ['icon'],
            'Separator' => ['separator'],
            'Tooltip' => ['tooltip'],
        ],
        'pro' => [
            'Accordion' => ['accordion'],
            'Autocomplete' => ['autocomplete'],
            'Badge' => ['badge'],
            'Breadcrumbs' => ['breadcrumbs'],
            'Card' => ['card'],
            'Checkbox' => ['checkbox'],
            'Command' => ['command'],
            'Context' => ['context'],
            'Field' => ['fieldset', 'legend', 'field', 'label', 'description', 'error'],
            'Editor' => ['editor'],
            'Heading' => ['heading', 'subheading', 'text', 'link'],
            'Input' => ['input'],
            'Layout' => ['header', 'sidebar', 'aside', 'main', 'footer', 'container', 'brand', 'profile', 'spacer'],
            'Modal' => ['modal'],
            'Navbar' => ['navbar', 'navlist'],
            'Radio' => ['radio'],
            'Select' => ['select', 'option', 'options'],
            'Switch' => ['switch'],
            'Table' => ['table', 'columns', 'column', 'rows', 'row', 'cell', 'pagination'],
            'Tabs' => ['tabs','tab'],
            'Textarea' => ['textarea'],
            'Toast' => ['toast'],
            'Typography' => ['heading', 'subheading', 'text', 'link'],
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
            ->filter(fn (string $component) => str($component)->lower()->startsWith($value))
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

        if ($filesystem->exists($destination) && !$this->option('force')) {
            warning("Skipping [{$component}]. Directory already exists: {$destination}");

            return null;
        }

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
