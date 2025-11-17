@extends('partner.layouts.master')
@section('title', __($title))

@push('custom-css')
    @include('partner.profile.styles.style')
@endpush

@section('content')
    <div class="container">
        <div class="mobile-view">
            @include('partner.profile.components.mobile-transaction')
        </div>

        <div class="laptop-view">
            @include('partner.profile.components.laptop-transaction')
        </div>
    </div>
@endsection

@push('custom-js')
    @include('partner.profile.scripts.scripts')
@endpush
