@php
    use App\Enums\Transaction\TransactionStatus;
    use App\Enums\Transaction\TransactionType;
@endphp

@extends('admin.layouts.master')
@push('libs-css')
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2-bootstrap-5-theme.min.css') }}">
@endpush
@push('custom-css')
    @include('admin.transaction.styles.style')
@endpush
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-form :action="route('admin.transaction.update')" type="put" :validate="true">
                <x-input type="hidden" name="id" :value="$transaction->id" />
                <div class="row justify-content-center">
                    @include('admin.transaction.forms.show-left')
                    @if ($transaction->type == TransactionType::Deposit->value || $transaction->type == TransactionType::Withdraw->value)
                        @include('admin.transaction.forms.show-right')
                    @endif
                </div>
            </x-form>
        </div>
        <div id="image-modal">
            <img src="" alt="Full Image">
        </div>
    </div>
@endsection

@push('libs-js')
    <!-- ckfinder js -->
    @include('ckfinder::setup')
    <script src="{{ asset('/public/libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('/public/libs/select2/dist/js/i18n/vi.js') }}"></script>
    <script src="{{ asset('/public/libs/jquery-throttle-debounce/jquery.ba-throttle-debounce.min.js') }}"></script>
@endpush

@push('custom-js')
    <script>
        $('.select2-bs5').select2({
            language: "vi",
            theme: 'bootstrap-5'
        });
    </script>
    @include('admin.transaction.scripts.script')
@endpush
