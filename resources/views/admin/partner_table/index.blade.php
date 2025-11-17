@extends('admin.layouts.master')

@push('libs-css')
@endpush

@push('custom-css')
    <style>
        .icon-category {
            font-size: 40px;
        }
    </style>
@endpush

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card custom-shadow">
                <div class="card-header justify-content-between">
                    <h2 class="mb-0">{{ __('Danh sách Bàn của ') }} {{ $partner->name }}</h2>
                    @if ($isAdmin)
                        <x-link :href="route('admin.partner.table.create', $partner->id)" class="btn btn-default-cms"><i
                                class="ti ti-plus"></i>{{ __('Thêm Bàn') }}</x-link>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive position-relative">
                        <x-admin.partials.toggle-column-datatable />
                        {{ $dataTable->table(['class' => 'table table-bordered', 'style' => 'min-width: 900px;'], true) }}
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal hiển thị QR -->
        <div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="qrModalLabel">Mã QR</h5>
                    </div>
                    <div class="modal-body" style="text-align: center;">
                        <div class="d-flex justify-content-center" id="qrcode"></div>
                        <a id="downloadQrBtn" href="#" download="qrcode.png" class="btn btn-outline-primary mt-3">
                            <i class="ti ti-download"></i> Tải xuống
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('libs-js')
    <!-- button in datatable -->
    <script src="{{ asset('/public/vendor/datatables/buttons.server-side.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
@endpush

@push('custom-js')
    {{ $dataTable->scripts() }}

    @include('admin.scripts.datatable-toggle-columns', [
        'id_table' => $dataTable->getTableAttribute('id'),
    ])


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('click', function(e) {
                const btn = e.target.closest('.btn-show-qr');
                if (!btn) return;

                const code = btn.dataset.value;
                const bookingUrl = "{{ asset('/checkin') }}/" + code;
                const logoUrl =
                    "{{ asset(\App\Models\Setting::where('setting_key', 'logo')->value('plain_value')) }}";
                const qrContainer = document.getElementById('qrcode');
                const downloadBtn = document.getElementById('downloadQrBtn');

                qrContainer.innerHTML = ''; // clear cũ

                // ⚡ B1. Render QR lên canvas
                const qr = new QRCode(qrContainer, {
                    text: bookingUrl,
                    // text: '00020101021238570010A00000072701270006970422011300018866938360208QRIBFTTA5303704540420005802VN62340830CSL7JEI8RO2 Nap 500 tim vao vi6304A163',
                    width: 300,
                    height: 300,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H,
                    useSVG: false
                });

                setTimeout(() => {
                    const canvas = qrContainer.querySelector('canvas');
                    if (!canvas) return;
                    const ctx = canvas.getContext('2d');
                    const logo = new Image();
                    logo.crossOrigin = "anonymous";
                    logo.src = logoUrl;

                    logo.onload = () => {
                        // ⚡ B2. Chèn logo vào giữa
                        const logoSize = canvas.width * 0.25;
                        const x = (canvas.width - logoSize) / 2;
                        const y = (canvas.height - logoSize) / 2;
                        ctx.drawImage(logo, x, y, logoSize, logoSize);

                        // ⚡ B3. Thêm viền trắng (padding)
                        const padding = 30; // px
                        const paddedCanvas = document.createElement('canvas');
                        const pCtx = paddedCanvas.getContext('2d');
                        paddedCanvas.width = canvas.width + padding * 2;
                        paddedCanvas.height = canvas.height + padding * 2;

                        // Vẽ nền trắng
                        pCtx.fillStyle = "#ffffff";
                        pCtx.fillRect(0, 0, paddedCanvas.width, paddedCanvas.height);

                        // Vẽ QR cũ vào giữa
                        pCtx.drawImage(canvas, padding, padding);

                        // ⚡ B4. Hiển thị ảnh có logo + padding trong modal
                        const imgPreview = new Image();
                        imgPreview.src = paddedCanvas.toDataURL("image/png");
                        imgPreview.classList.add('img-fluid', 'shadow');
                        qrContainer.innerHTML = '';
                        qrContainer.appendChild(imgPreview);

                        // ⚡ B5. Cho phép tải ảnh QR (có logo + padding)
                        downloadBtn.href = imgPreview.src;
                        downloadBtn.download = `qr-${code}.png`;
                    };
                }, 300);

                // ⚡ B6. Hiển thị modal
                new bootstrap.Modal(document.getElementById('qrModal')).show();
            });
        });
    </script>
@endpush
