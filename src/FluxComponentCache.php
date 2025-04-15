<?php

namespace Flux;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class FluxComponentCache
{
    /**
     * A mapping of all components that can be cached.
     *
     * @var array
     */
    protected $cacheableComponents = [];

    /**
     * @var array
     */
    protected $observedComponents = [];

    protected $observingStack = [];

    protected $items = [];

    protected $swaps = [];

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
        $ignoreKeys = $observedComponent['ignore'] ?? [];
        $uses = $observedComponent['uses'] ?? [];

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
        }

        return $component . '|' .serialize($cacheData);
    }

    public function startObserving(string $componentName)
    {
        $this->observingStack[] = [
            'component' => $componentName,
            'cacheable' => false,
            'ignore' => [],
            'uses' => [],
        ];
    }

    public function stopObserving(string $componentName)
    {
        $lastObserved = array_pop($this->observingStack);
        $lastObserved['ignore'] = array_flip($lastObserved['ignore']);

        if ($lastObserved['cacheable']) {
            $this->observedComponents[$componentName] = $lastObserved;
            $this->cacheableComponents[$componentName] = true;
        } else {
            // Don't need a ton of extra information here
            // Just need to know we've seen it before
            $this->observedComponents[$componentName] = 1;
        }
    }

    public function ignore($keys)
    {
        $keys = Arr::wrap($keys);

        $this->observingStack[array_key_last($this->observingStack)]['ignore'] = $keys;
    }

    public function usesVariable(string $name, $currentValue, $default = null)
    {
        $this->observingStack[array_key_last($this->observingStack)]['uses'][$name] = [$currentValue, $default];
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
        $component = $this->observingStack[array_key_last($this->observingStack)]['component'];

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
}