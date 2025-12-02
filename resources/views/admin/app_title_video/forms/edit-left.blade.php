<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header justify-content-center">
            <h2 class="mb-0">{{ __('Thông tin Video Tiêu đề') }}</h2>
        </div>
        <div class="row card-body">
            <!-- key -->
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-key"></i> {{ __('Từ khóa') }}:</label>
                    <x-input name="key" :value="$app_title_video->key" :required="true" placeholder="{{ __('Từ khóa') }}"
                        disabled />
                </div>
            </div>

            <!-- name -->
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-tags"></i> {{ __('Tên') }}:</label>
                    <x-input name="name" :value="$app_title_video->name" :required="true" placeholder="{{ __('Tên') }}"
                        disabled />
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-video"></i> {{ __('Video') }}:</label>
                    <div>
                        <input id="file-input-{{ $app_title_video->key }}" name="value_file" type="file"
                            accept="video/*">

                        <input type="hidden" name="value" id="video-base64-{{ $app_title_video->key }}">

                        <video class="mt-2 w-100 h-auto" id="video-{{ $app_title_video->key }}" controls
                            preload="metadata">
                            @if ($app_title_video->value)
                                <source src="{{ asset($app_title_video->value) }}">
                            @endif
                        </video>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<script>
    (function() {
        const input = document.getElementById('file-input-{{ $app_title_video->key }}');
        const video = document.getElementById('video-{{ $app_title_video->key }}');
        const hidden = document.getElementById('video-base64-{{ $app_title_video->key }}');

        if (!input || !video || !hidden) return;

        const form = input.closest('form');
        if (!form) return;

        let isReading = false;

        input.addEventListener('change', function(e) {
            const file = e.target.files && e.target.files[0];
            if (!file) {
                hidden.value = '';
                return;
            }

            // 1) Preview video như cũ
            const url = URL.createObjectURL(file);

            while (video.firstChild) {
                video.removeChild(video.firstChild);
            }

            const source = document.createElement('source');
            source.src = url;
            source.type = file.type || 'video/mp4';
            video.appendChild(source);

            video.load();
            video.play().catch(() => {});

            // 2) Đọc file -> base64 (data URL)
            const reader = new FileReader();
            isReading = true;

            reader.onload = function(ev) {
                const result = ev.target.result; // data:video/mp4;base64,AAAA...
                hidden.value = result;
                isReading = false;
            };

            reader.onerror = function() {
                console.error('Lỗi khi đọc file video');
                hidden.value = '';
                isReading = false;
            };

            reader.readAsDataURL(file);
        });

        // Chặn submit nếu base64 chưa xong
        form.addEventListener('submit', function(e) {
            // Nếu đã chọn file mà base64 chưa có
            if (input.files.length > 0 && !hidden.value) {
                if (isReading) {
                    e.preventDefault();
                    alert('Đang xử lý video, vui lòng đợi 1 chút rồi bấm lưu lại.');
                }
            }
        });
    })();
</script>
