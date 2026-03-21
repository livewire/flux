@blaze(fold: true, unsafe: [
    // variant props
    'name', 'placeholder', 'invalid', 'size', 'clear', 'close',
    'selectedSuffix', 'searchable', 'clearable', 'button', 'input', 'trigger', 'search', 'empty', 'multiple',
    // flux:with-field props
    'name', 'label', 'badge',
    'description', 'description:trailing',
    'label:badge', 'label:aside', 'label:trailing',
    'error:name', 'error:bag', 'error:message', 'error:icon', 'error:nested', 'error:deep',
])

@props([
    'variant' => 'default',
])

<flux:with-field :$attributes>
    <flux:delegate-component :component="'select.variants.' . $variant">{{ $slot }}</flux:delegate-component>
</flux:with-field>
