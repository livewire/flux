<?php

namespace Flux;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\ComponentAttributeBag;

class FluxComponentCache
{
    /**
     * A mapping of all components that can be cached.
     *
     * @var array
     */
    protected $cacheableComponents = [];

    protected $optimizedComponents = [];

    /**
     * @var array
     */
    protected $observedComponents = [];

    protected $observingStack = [];

    protected $items = [];

    protected $swaps = [];

    protected $setupFunctions = [];

    protected function shouldSkipComponent($component)
    {
        if (! isset($this->observedComponents[$component])) {
            return true;
        }

        if (! isset($this->cacheableComponents[$component])) {
            return true;
        }

        return false;
    }

    public function key($component, $data, $env)
    {
        // Optimized components will share the same key
        // The component's contents will always be
        // re-evaluated, so we don't need data
        if (array_key_exists($component, $this->optimizedComponents)) {
            return $component;
        }

        if ($this->shouldSkipComponent($component)) {
            return null;
        }

        $cacheData = [];

        foreach ($data as $k => $v) {
            // Ignore data that is likely internal state.
            if (Str::startsWith($k, '__')) {
                continue;
            }

            // Skip the default slot.
            if ($k == 'slot') {
                continue;
            }

            $cacheData[$k] = $v;
        }

        ksort($cacheData);

        $observedComponent = $this->observedComponents[$component];
        $ignoreKeys = $observedComponent['exclude'] ?? [];
        $uses = $observedComponent['aware'] ?? [];

        if (count($uses) > 0) {
            foreach ($uses as $variableName => $details) {
                if (isset($cacheData[$variableName])) {
                    continue;
                }

                // Get the data from the stack so we
                // can use it as part of the key
                $cacheData[$variableName] = $env->getConsumableComponentData(
                    $variableName, $details[1]
                );
            }
        }

        if (count($ignoreKeys) > 0) {
            $cacheData = array_diff_key($cacheData, $ignoreKeys);

            // If we find an attribute bag, we will want to exclude
            // our ignored values from that as well. If we do
            // not do this, the ignored values will sneak
            // into the cache key this way, usually in
            // components that are nested in others
            foreach ($cacheData as $k => $v) {
                if (! $v instanceof ComponentAttributeBag) {
                    continue;
                }

                $cacheData[$k] = $v->except(array_keys($ignoreKeys));
            }
        }

        return $component . '|' .serialize($cacheData);
    }

    public function startObserving(string $componentName)
    {
        $this->observingStack[] = [
            'component' => $componentName,
            'cacheable' => false,
            'exclude' => [],
            'aware' => [],
        ];
    }

    public function stopObserving(string $componentName)
    {
        $lastObserved = array_pop($this->observingStack);
        $lastObserved['exclude'] = array_flip($lastObserved['exclude']);

        if ($lastObserved['cacheable']) {
            $this->observedComponents[$componentName] = $lastObserved;
            $this->cacheableComponents[$componentName] = true;
        } else {
            // Don't need a ton of extra information here
            // Just need to know we've seen it before
            $this->observedComponents[$componentName] = 1;
        }
    }

    public function currentComponent()
    {
        return $this->observingStack[array_key_last($this->observingStack)]['component'];
    }

    public function exclude($keys)
    {
        $keys = Arr::wrap($keys);

        $this->observingStack[array_key_last($this->observingStack)]['exclude'] = $keys;
    }

    public function usesVariable(string $name, $currentValue, $default = null)
    {
        $this->observingStack[array_key_last($this->observingStack)]['aware'][$name] = [$currentValue, $default];
    }

    public function isOptimized()
    {
        $this->isCacheable();

        $this->optimizedComponents[$this->currentComponent()] = true;
    }

    public function isCacheable()
    {
        $lastKey = array_key_last($this->observingStack);
        $lastObserved = $this->observingStack[$lastKey];
        $lastObserved['cacheable'] = true;

        $this->observingStack[$lastKey] = $lastObserved;
    }

    public function has($key)
    {
        return array_key_exists($key, $this->items);
    }

    public function put($component, $key, $result)
    {
        if ($this->shouldSkipComponent($component)) {
            return;
        }

        $this->items[$key] = $result;
    }

    public function get($key)
    {
        return $this->items[$key];
    }

    public function addSwap($replacement, $callback)
    {
        $component = $this->currentComponent();

        if (! array_key_exists($component, $this->swaps)) {
            $this->swaps[$component] = [];
        }

        $this->swaps[$component][$replacement] = $callback;
    }

    public function swap($component, $value, $data)
    {
        if (! isset($this->swaps[$component])) {
            return $value;
        }

        foreach ($this->swaps[$component] as $replacement => $callback) {
            $value = str_replace($replacement, $callback($data), $value);
        }

        return $value;
    }

    public function registerSetup($callback)
    {
        $component = $this->currentComponent();

        $this->setupFunctions[$component] = $callback;
    }

    public function runCurrentComponentSetup($data)
    {
        return $this->runComponentSetup($this->currentComponent(), $data);
    }

    public function runComponentSetup($component, $data)
    {
        if (! array_key_exists($component, $this->setupFunctions)) {
            return $data;
        }

        return $this->setupFunctions[$component]($data);
    }
}