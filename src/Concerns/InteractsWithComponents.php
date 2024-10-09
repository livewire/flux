<?php

namespace Flux\Concerns;

use Livewire\Component;
use Flux\Flux;

trait InteractsWithComponents
{
    public function bootComponents()
    {
        $this->bootModal();
    }

    public function bootModal()
    {
        Component::macro('modal', function ($name) {
            return new class ($name) {
                public function __construct(public $name) {}

                public function show()
                {
                    $component = app('livewire')->current();

                    $component->dispatch('modal-show', name: $this->name, scope: $component->getId());
                }

                public function close()
                {
                    $component = app('livewire')->current();

                    $component->dispatch('modal-close', name: $this->name, scope: $component->getId());
                }
            };
        });
    }

    public function modal($name)
    {
        return new class ($name) {
            public function __construct(public $name) {}

            public function show()
            {
                app('livewire')->current()->dispatch('modal-show', name: $this->name);
            }

            public function close()
            {
                app('livewire')->current()->dispatch('modal-close', name: $this->name);
            }
        };
    }

    public function modals()
    {
        return new class {
            public function close()
            {
                app('livewire')->current()->dispatch('modal-close');
            }
        };
    }

    public function toast($text, $heading = null, $duration = 5000, $variant = null, $position = null)
    {
        $params = [
            'duration' => $duration,
            'slots' => [],
            'dataset' => [],
        ];

        if ($text) $params['slots']['text'] = $text;
        if ($heading) $params['slots']['heading'] = $heading;
        if ($variant) $params['dataset']['variant'] = $variant;
        if ($position) $params['dataset']['position'] = $position;

        app('livewire')->current()->dispatch('toast-show', ...$params);
    }
}
