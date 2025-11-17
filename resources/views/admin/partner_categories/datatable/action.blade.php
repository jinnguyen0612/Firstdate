@php
    $isAdmin = auth('admin')->user()->hasRole('superAdmin');
@endphp
<div class="d-flex justify-content-center">
    <a href="{{ route('admin.partner_category.edit', $id) }}"><x-button type="button" class="btn-info btn-icon">
            <i class="ti ti-pencil"></i>
    </x-button></a>
    @if($isAdmin)
    <x-button.modal-delete class="btn-icon me-2" data-route="{{ route('admin.partner_category.delete', $id) }}">
        <i class="ti ti-trash"></i>
    </x-button.modal-delete>
    @endif
</div>