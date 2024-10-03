<?php

namespace Flux;

use Flux\Helpers\Regex;
use Illuminate\View\Compilers\ComponentTagCompiler;

class FluxTagCompiler extends ComponentTagCompiler
{
    public function componentString(string $component, array $attributes)
    {
        return parent::componentString($component, $attributes);
    }

    /**
     * Compile the opening tags within the given string.
     *
     * @param  string  $value
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    protected function compileOpeningTags(string $value)
    {
        return preg_replace_callback(Regex::getOpenTagPattern(), function (array $matches) {
            $this->boundAttributes = [];

            $attributes = $this->getAttributesFromAttributeString($matches['attributes']);

            return $this->componentString('flux::'.$matches[1], $attributes);
        }, $value);
    }

    /**
     * Compile the self-closing tags within the given string.
     *
     * @param  string  $value
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    protected function compileSelfClosingTags(string $value)
    {
        return preg_replace_callback(Regex::getSelfClosingTagPattern(), function (array $matches) {
            $this->boundAttributes = [];

            $attributes = $this->getAttributesFromAttributeString($matches['attributes']);

            // Support inline "slot" attributes...
            if (isset($attributes['slot'])) {
                $slot = $attributes['slot'];

                unset($attributes['slot']);

                return '@slot('.$slot.') ' . $this->componentString('flux::'.$matches[1], $attributes)."\n@endComponentClass##END-COMPONENT-CLASS##" . ' @endslot';
            }

            return $this->componentString('flux::'.$matches[1], $attributes)."\n@endComponentClass##END-COMPONENT-CLASS##";
        }, $value);
    }

    /**
     * Compile the closing tags within the given string.
     *
     * @param  string  $value
     * @return string
     */
    protected function compileClosingTags(string $value)
    {
        return preg_replace("/<\/\s*flux[\:][\w\-\:\.]*\s*>/", ' @endComponentClass##END-COMPONENT-CLASS##', $value);
    }
}
