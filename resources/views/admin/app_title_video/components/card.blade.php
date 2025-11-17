<style>
    video {
        border: 1px solid black;
        display: block;
        max-width: 100%;
        height: auto;
    }
</style>

<div class="card rounded text-center overflow-hidden border-0 shadow col-md-6 col-12 gap-1 mt-2">
    <div class="p-2 rounded" style="background: linear-gradient(to bottom, rgb(242, 24, 90), rgb(240, 24, 60));">
        <input type="hidden" name="titles[{{ $index }}][id]" value="{{ $title->id }}">
        <div class="text-white">
            <div class="col-12">
                <label class="control-label">{{ $title->key }}</label>
            </div>
            <div class="col-12">
                <label class="control-label">{{ $title->name }}</label>
            </div>
        </div>
    </div>

    <div class="card-body bg-dark text-white d-flex justify-content-center align-items-center flex-column">
        <input id="file-input-{{ $title->key }}" name="titles[{{ $index }}][value]" type="file"
               accept="video/*">

        <video class="mt-2" id="video-{{ $title->key }}" controls preload="metadata" width="300" height="200">
            @if ($title->value)
                <source src="{{ asset($title->value) }}">
            @endif
        </video>
    </div>
</div>

<script>
    (function () {
        const input = document.getElementById('file-input-{{ $title->key }}');
        const video = document.getElementById('video-{{ $title->key }}');

        if (!input || !video) return;

        input.addEventListener('change', function (e) {
            const file = e.target.files && e.target.files[0];
            if (!file) return;

            // Tạo URL tạm cho video
            const url = URL.createObjectURL(file);

            // Xoá source cũ (nếu có)
            while (video.firstChild) {
                video.removeChild(video.firstChild);
            }

            const source = document.createElement('source');
            source.src = url;
            source.type = file.type || 'video/mp4';
            video.appendChild(source);

            video.load();
            video.play().catch(() => {
                // Trường hợp browser chặn autoplay, ít nhất vẫn load được preview
            });
        });
    })();
</script>
