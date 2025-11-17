<input type="text" {{ $attributes->class(['d-none']) }} name="{{ $name }}" value="{{ $value }}">

<video id="{{ $showImage }}" class="add-image-ckfinder pointer"
	data-preview="#{{ $showImage }}"
	data-input="input[name='{{ $name }}']"
	style="width: 100%" controls>
	<source src="{{ asset($value) }}" type="video/mp4">
	Your browser does not support the video tag.
</video>

@push('scripts')
<script>
	document.addEventListener('DOMContentLoaded', function () {
		const video = document.getElementById('{{ $showImage }}');
		const input = document.querySelector("input[name='{{ $name }}']");

		if (video && input) {
			input.addEventListener('change', function () {
				const url = this.value;
				const source = video.querySelector('source');

				if (source) {
					source.src = url;
					video.load();
				}
			});
		}
	});
</script>
@endpush
