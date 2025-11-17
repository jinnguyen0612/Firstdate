@php
    $isAdmin = auth('admin')->user()->hasRole('superAdmin');
@endphp
<div class="d-flex align-items-center justify-content-center">
    <a style="margin-right: 0.3rem" href="{{ route('admin.user.edit', $id) }}" class="ml-2">
        <i class="btn btn-info btn-icon ti ti-file-description"></i>
    </a>
    @if($isAdmin)
    <x-button.modal-delete class="btn-icon" data-route="{{ route('admin.user.delete', $id) }}">
        <i class="ti ti-trash"></i>
    </x-button.modal-delete>
    @endif
</div>