@blaze(fold: true)

{{-- How far it reaches, and which corners it rounds, depend on where it sits: always out to the sides, and up or
down only from the start or end of a body or card (see flux.css)... --}}
<div {{ $attributes }} data-flux-card-bleed>
    {{ $slot }}
</div>
