@php
    $isAdmin = auth('admin')->user()->hasRole('superAdmin');
@endphp
<div class="d-flex justify-content-center">
    <a href="{{ route('admin.partner.table.edit', $id) }}"><x-button type="button" class="btn-info btn-icon me-2">
            <i class="ti ti-pencil"></i>
        </x-button></a>
    @if ($isAdmin)
        <x-button.modal-delete class="btn-icon me-2" data-route="{{ route('admin.partner.table.delete', $id) }}">
            <i class="ti ti-trash"></i>
        </x-button.modal-delete>
    @endif
    <span class="me-2 btn-show-qr" data-bs-toggle="modal" data-bs-target="#qrModal" data-value="{{ $code }}">
        <div data-bs-toggle="tooltip" title="{{ __('Xem mã QR') }}">
            <i class="btn btn-info btn-icon ti ti-qrcode"></i>
        </div>
    </span>
</div>
