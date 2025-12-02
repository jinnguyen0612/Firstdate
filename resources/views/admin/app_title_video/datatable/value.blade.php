<video class="mt-2" id="video-{{ $key }}" controls preload="metadata" width="300" height="200">
    @if ($value)
        <source src="{{ asset($value) }}">
    @endif
</video>
