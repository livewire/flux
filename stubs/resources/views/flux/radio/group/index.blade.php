@blaze(fold: true, unsafe: [
    // variant props
    'size', 'name',
    // flux:with-field props
    'name', 'label', 'badge',
    'description', 'description:trailing',
    'label:badge', 'label:aside', 'label:trailing',
    'error:name', 'error:bag', 'error:message', 'error:icon', 'error:nested', 'error:deep',
])

@props([
    'variant' => 'default',
])

<flux:delegate-component :component="'radio.group.variants.' . $variant">{{ $slot }}</flux:delegate-component>
