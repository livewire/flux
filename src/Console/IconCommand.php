<?php

declare(strict_types=1);

namespace Flux\Console;

use Symfony\Component\Console\Attribute\AsCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Http;
use Illuminate\Console\Command;

use function Laravel\Prompts\error;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\info;
use function Laravel\Prompts\note;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\text;

#[AsCommand(name: 'flux:icon')]
class IconCommand extends Command
{
    protected $signature = 'flux:icon {icons?*}';

    protected $description = 'Import third-party icons from Lucide.';

    public function handle(): void
    {
        if (count($icons = $this->argument('icons')) > 0) {
            foreach ($icons as $icon) {
                $this->publishIcon($icon);
            }

            return;
        }

        intro("Need an icon not included in Heroicons?");
        info("Search for the perfect icon at: https://lucide.dev/icons");

        prompt:

        $icon = text(
            label: 'Which icon would you like to import from Lucide?',
            required: 'An icon name is required.',
            placeholder: 'e.g. arrow-left',
        );

        $this->publishIcon($icon);

        if (confirm('Would you like to import another icon?')) {
            goto prompt;
        }
    }

    protected function publishIcon(string $icon): void
    {
        $response = spin(
            message: 'Fetching icon...',
            callback: fn () => Http::get('https://raw.githubusercontent.com/lucide-icons/lucide/main/icons/'.$icon.'.svg')
        );

        if ($response->failed() || $response->status() !== 200) {
            error('Failed to fetch icon: '.$icon);

            return;
        }

        $svg = $response->body();

        (new Filesystem)->ensureDirectoryExists(resource_path('views/flux/icon'));

        $destinationAsFile = resource_path('views/flux/icon/'.$icon.'.blade.php');

        file_put_contents($destinationAsFile, $this->generateIconBlade($svg));

        info('Published icon: ' . $destinationAsFile);
    }

    protected function generateIconBlade($svg) {
        $svg = str($svg)
            ->replaceMatches('/<svg.*?>/s', <<<'SVG'
            <svg
                {{ $attributes->class($classes) }}
                data-flux-icon
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="{{ $strokeWidth }}"
                stroke-linecap="round"
                stroke-linejoin="round"
                aria-hidden="true"
                data-slot="icon"
            >
            SVG)->toString();

        $stub = <<<'HTML'
        {{-- Credit: Lucide (https://lucide.dev) --}}

        @props([
            'variant' => 'outline',
        ])

        @php
        if ($variant === 'solid') {
            throw new \Exception('The "solid" variant is not supported in Lucide.');
        }

        $classes = Flux::classes('shrink-0')
            ->add(match($variant) {
                'outline' => '[:where(&)]:size-6',
                'solid' => '[:where(&)]:size-6',
                'mini' => '[:where(&)]:size-5',
                'micro' => '[:where(&)]:size-4',
            });

        $strokeWidth = match ($variant) {
            'outline' => 2,
            'mini' => 2.25,
            'micro' => 2.5,
        };
        @endphp

        [[INJECT:SVG]]
        HTML;

        return (string) str($stub)->replace('[[INJECT:SVG]]', $svg);
    }
}
