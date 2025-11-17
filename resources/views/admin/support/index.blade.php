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
                    <h2 class="mb-0">{{ __('Câu hỏi hỗ trợ') }}</h2>
                    @if ($isAdmin)
                        <x-link :href="route('admin.support.create', $category->id)" class="btn btn-default-cms"><i
                                class="ti ti-plus"></i>{{ __('Thêm Câu hỏi') }}</x-link>
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
    </div>
@endsection

@push('libs-js')
    <!-- button in datatable -->
    <script src="{{ asset('/public/vendor/datatables/buttons.server-side.js') }}"></script>
@endpush

@push('custom-js')
    {{ $dataTable->scripts() }}

    @include('admin.scripts.datatable-toggle-columns', [
        'id_table' => $dataTable->getTableAttribute('id'),
    ])
@endpush
