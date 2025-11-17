@extends('admin.layouts.master')
@push('libs-css')
				<link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2.min.css') }}">
				<link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2-bootstrap-5-theme.min.css') }}">
				<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
@endpush
@push('custom-css')
	@include('admin.deal.styles.style')
@endpush
@section('content')
				<div class="page-body">
								<div class="container-xl">
									<div class="row justify-content-center">
										@include('admin.deal.forms.show-left')
									</div>
								</div>
				</div>
@endsection

@push('libs-js')
				<!-- ckfinder js -->
				@include('ckfinder::setup')
				<script src="{{ asset('/public/libs/select2/dist/js/select2.min.js') }}"></script>
				<script src="{{ asset('/public/libs/select2/dist/js/i18n/vi.js') }}"></script>
				<script src="{{ asset('/public/libs/jquery-throttle-debounce/jquery.ba-throttle-debounce.min.js') }}"></script>
				<!-- Swiper JS -->
  				<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
@endpush

@push('custom-js')
				@include('admin.deal.scripts.scripts')
				<script>
								$('.select2-bs5').select2({
												language: "vi",
												theme: 'bootstrap-5'
								});
				</script>
@endpush
