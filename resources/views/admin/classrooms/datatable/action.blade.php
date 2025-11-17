<a href="{{ route('admin.classroom.edit', $id) }}"><x-button type="button" class="btn-info btn-icon">
        <i class="ti ti-pencil"></i>
    </x-button></a>
<x-button.modal-delete class="btn-icon" data-route="{{ route('admin.classroom.delete', $id) }}">
    <i class="ti ti-trash"></i>
</x-button.modal-delete>