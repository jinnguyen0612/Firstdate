@php
    $isAdmin = auth('admin')->user()->hasRole('superAdmin');
@endphp
<div class="d-flex justify-content-center align-items-center">
    <a href="{{ route('admin.price_list.edit', $id) }}"><x-button type="button" class="btn-info btn-icon me-2">
            <i class="ti ti-pencil"></i>
    </x-button></a>
    @if($isAdmin)
    <x-button.modal-delete class="btn-icon me-2" data-route="{{ route('admin.price_list.delete', $id) }}">
        <i class="ti ti-trash"></i>
    </x-button.modal-delete>
    @endif
</div>