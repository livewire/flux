<?php

namespace Flux\Console;

use RuntimeException;
use function Laravel\Prompts\{ info, text, note, spin, warning, error, alert, intro, outro, suggest };
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Http;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

#[AsCommand(name: 'flux:activate')]
class ActivateCommand extends Command
{
    protected $signature = 'flux:activate {email?} {key?}';

    protected $description = 'Activate Flux, the official UI component library for Livewire';

    public function handle()
    {
        $email = $this->argument('email');
        $key = $this->argument('key');

        if (! $email) {
            $email = text(
                label: 'Enter the email address associated with your license',
                hint: 'Purchase a license key: https://fluxui.dev/pricing',
                required: true,
            );
        }

        if (! $key) {
            $key = text(
                label: 'Enter your license key',
                hint: 'Purchase a license key: https://fluxui.dev/pricing',
                required: true,
            );
        }

        $this->installFluxPro($email, $key);
    }

    public function installFluxPro($email, $key)
    {
        // Add creds to auth.json...
        $process = new Process([
            'composer', 'config', '-a',
            'http-basic.composer.fluxui.dev', $email, $key
        ]);

        $process->run();

        if (! $process->isSuccessful()) {
            echo "Failed to add license to auth.json. Console output: " . $process->getErrorOutput();
            note('Contact support@fluxui.dev for help');
            return;
        }

        info('[√] License key added to auth.json');

        // Add repository to composer.json...
        $process = new Process(['composer', 'config', 'repositories.flux-pro', 'composer', 'https://composer.fluxui.dev']);

        $process->run();

        if (! $process->isSuccessful()) {
            echo "Failed to add repository to composer.json. Console output: " . $process->getErrorOutput();
            note('Contact support@fluxui.dev for help');
            return;
        }

        info('[√] Repository added to composer.json');

        // Run composer require...
        note('Running: composer require livewire/flux-pro...');

        $process = new Process(['composer', 'require', 'livewire/flux-pro']);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            try {
                $process->setTty(true);
            } catch (RuntimeException $e) {
                $this->output->writeln('  <bg=yellow;fg=black> WARN </> '.$e->getMessage().PHP_EOL);
            }
        }

        $process->setTimeout(null);

        $process->run(function ($type, $line) {
            $this->output->write('    '.$line);
        });

        if (! $process->isSuccessful()) {
            error("We are unable to install Flux automatically. Try running `composer require livewire/flux-pro` manually.");
            note('Contact support@fluxui.dev for help');
            return;
        }

        note('');
        outro('Thanks for using Flux!');
        note('Your support is an investment in the future of Livewire ❤️');
    }
}
