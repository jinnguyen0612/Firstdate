@extends('admin.layouts.guest.master')

@section('content')
				<div class="page page-center" style="background-color: #f5d5bb;">
								<div style="border-radius: 15px" class="container-tight py-4">
												<x-form style="border-radius: 15px" :action="route('admin.login.post')" class="card card-md bg-dark text-white" type="post"
																:validate="true">
																<div class="card-body shadow-sm">
																				<h2 class="card-title mb-4 text-center">{{ __('WELCOME') }}</h2>
																				<div class="mb-4 text-center">
																								<img class="img-fluid" src="{{ asset('assets/images/light-hori-logo.png') }}" class="rounded-circle"
																												alt="">
																				</div>
																				<p class="mb-4 text-center">{{ __('Để đăng nhập được nhập đầy đủ thông tin bên dưới') }}</p>
																				<div class="mb-3">
																								<label class="form-label">{{ __('Tài khoản') }}</label>
																								<x-input-email name="email" :required="true" />
																				</div>
																				<div class="mb-3">
																								<label class="form-label">{{ __('Mật khẩu') }}</label>
																								<x-input-password name="password" :required="true" />
																				</div>
																				{{-- <div class="mb-3 text-end">
																								<a href="#" class="text-decoration-none text-muted">{{ __('Forgot Password') }}</a>
            </div> --}}
																				<div class="form-footer">
																								<button style="background: linear-gradient(135deg, #0c367a, #61778d);" type="submit"
																												class="btn btn-primary w-100">{{ __('Đăng nhập') }}</button>
																				</div>
																				{{-- <div class="mt-4 text-center">
																								<p>{{ __("Don't have an account?") }} <a href="#"
                class="text-decoration-none">{{ __('SIGN UP') }}</a></p>
    </div> --}}
																</div>
												</x-form>
								</div>
				</div>
@endsection

<style>
				.form-control {
								color: black !important;
								/* Đặt màu chữ thành đen */
				}
</style>
