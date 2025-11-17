@extends('admin.layouts.master')

@section('content')
				<div class="page-header d-print-none">
								<div class="container-xl">
												<div class="row g-2 align-items-center">
																<div class="col">
																				<nav class="fancy-breadcrumb" aria-label="breadcrumb">
																								<ol class="breadcrumb-list">
																												<li class="breadcrumb-item">
																																<a href="{{ route('admin.dashboard') }}" class="breadcrumb-link">
																																				<span class="breadcrumb-icon">
																																								🏠
																																				</span>
																																				<span class="breadcrumb-text">{{ __('Dashboard') }}</span>
																																</a>
																												</li>
																												<li class="breadcrumb-item active" aria-current="page">
																																<span class="breadcrumb-link">
																																				<span class="breadcrumb-icon">📍</span>
																																				<span class="breadcrumb-text">{{ __('Đổi mật khẩu') }}</span>
																																</span>
																												</li>
																								</ol>
																				</nav>
																</div>
												</div>
								</div>
				</div>
				<div class="page-body">
								<div class="container-xl">
												<div class="row justify-content-center">
																<div class="col-12 col-md-6">
																				<x-form :action="route('admin.password.update')" type="put" enctype="multipart/form-data" :validate="true">
																								<div class="card">
																												<div class="card-header justify-content-center">
																																<h2 class="mb-0">{{ __('Đổi mật khẩu') }}</h2>
																												</div>
																												<div class="card-body">
																																<!-- password old -->
																																<div class="mb-3">
																																				<label class="control-label"><i class="ti ti-key"></i> {{ __('Mật khẩu cũ') }}:
																																								<span class="text-danger">*</span></label>
																																				<x-input-password name="old_password" :required="true" />
																																</div>
																																<!-- new password -->
																																<div class="mb-3">
																																				<label class="control-label"><i class="ti ti-key"></i> {{ __('Mật khẩu mới') }}:
																																								<span class="text-danger">*</span></label>
																																				<x-input-password name="password" :required="true" />
																																</div>
																																<!-- new password confirmation-->
																																<div class="mb-3">
																																				<label class="control-label"><i class="ti ti-key"></i> {{ __('Xác nhận mật khẩu') }}:
																																								<span class="text-danger">*</span></label>
																																				<x-input-password name="password_confirmation" :required="true"
																																								data-parsley-equalto="input[name='password']"
																																								data-parsley-equalto-message="{{ __('Mật khẩu không khớp.') }}" />
																																</div>
																												</div>
																												<div class="card-footer mt-auto bg-transparent">
																																<div class="btn-list justify-content-center">
																																				<x-button.submit :title="__('Đổi mật khẩu')" />
																																</div>
																												</div>
																								</div>
																				</x-form>
																</div>
												</div>
								</div>
				</div>
@endsection
