@props(['value' => null])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-base-content']) }}>
    @if(!is_null($value))
        {{ $value }}
    @else
        {{ $slot }}
    @endif
</label>
