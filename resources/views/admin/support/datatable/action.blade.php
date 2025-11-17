@php
    $isAdmin = auth('admin')->user()->hasRole('superAdmin');
@endphp
<div class="d-flex justify-content-center">
    <a href="{{ route('admin.support.edit', ['support_category_id' => $support_category_id, 'id' => $id]) }}"><x-button type="button" class="btn-info btn-icon me-2">
            <i class="ti ti-pencil"></i>
    </x-button></a>
    @if($isAdmin)
    <x-button.modal-delete class="btn-icon me-2" data-route="{{ route('admin.support.delete', $id) }}">
        <i class="ti ti-trash"></i>
    </x-button.modal-delete>
    @endif
</div>