<div class="col-12 col-md-9">
				<!-- Thông tin đăng nhập -->
				<div class="card mb-3">
								<div class="card-header">
												<h2 class="mb-0">{{ __('Thông tin đăng nhập') }}</h2>
								</div>
								<div class="row card-body">

												<div class="col-md-6 col-12">
																<div class="mb-3">
																				<label class="control-label"><i class="ti ti-mail"></i> {{ __('Email đăng nhập') }}:</label>
																				<x-input-email id="emailInput" name="email" :value="old('email')" />
																</div>
												</div>

												<div class="col-md-6 col-12">
																<div class="mb-3">
																				<label class="control-label"><i class="ti ti-phone"></i>
																								{{ __('Số điện thoại đăng nhập') }}:</label>
																				<x-input-phone name="phone" :value="old('phone')"
																								placeholder="{{ __('Số điện thoại đăng nhập') }}" />
																</div>
												</div>

												<div class="col-md-6 col-12">
																<div class="mb-3">
																				<label class="control-label"><i class="ti ti-key"></i> {{ __('Mật khẩu') }}:</label>
																				<x-input-password name="password" />
																</div>
												</div>

												<div class="col-md-6 col-12">
																<div class="mb-3">
																				<label class="control-label"><i class="ti ti-key"></i> {{ __('Xác nhận mật khẩu') }}:</label>
																				<x-input-password name="password_confirmation" data-parsley-equalto="input[name='password']"
																								data-parsley-equalto-message="{{ __('Mật khẩu không khớp.') }}" />
																</div>
												</div>
								</div>
				</div>

				<!-- Thông tin cơ bản -->
				<div class="card mb-3">
								<div class="card-header">
												<h2 class="mb-0">{{ __('Thông tin cơ bản') }}</h2>
								</div>
								<div class="row card-body">
												<div class="col-md-6 col-12">
																<div class="mb-3">
																				<label class="control-label"><i class="ti ti-user-edit"></i> {{ __('Tên Đối tác') }}:</label>
																				<x-input name="name" :value="old('name')" placeholder="{{ __('Tên Đối tác') }}" />
																</div>
												</div>
												
												<div class="col-md-6 col-12">
																<div class="mb-3">
																	<label class="control-label"><i class="ti ti-user"></i> {{ __('Loại đối tác') }}:</label>
																	<x-select style="width: 100%;" name="partner_category_id" class="select2-bs5-ajax" :data-url="route('admin.search.select.partner_category')" id="partner_category_id">
																	</x-select>
																</div>
												</div>

												{{-- address --}}
												<div class="col-12">
																<div class="mb-3">
																				<label class="control-label"><i class="ti ti-user-edit"></i> {{ __('Địa chỉ') }}:</label>
																				<x-input name="address" :value="old('address')" placeholder="{{ __('Số nhà, tên đường, phường/xã') }}" />
																</div>
												</div>

												<div class="col-12">
													<div class="mb-3">
														<x-input-pick-address :label="__('Địa chỉ nơi ở hiện tại')" province="province" district="district" :placeholder="__('Địa chỉ nơi ở hiện tại')" :required="true" />
													</div>
												</div>
												
												{{-- Hidden fields --}}
												<input type="hidden" name="lat">
												<input type="hidden" name="lng">
												<input type="hidden" name="province">
												<input type="hidden" name="district">

												<div class="col-12">
													<div class="mb-3">
														<label class="control-label"><i class="ti ti-bookmark"></i> {{ __('Mô tả ngắn') }}:</label>
														<x-textarea maxlength="500" name="description" :value="old('description')" :required="false"
																	placeholder="{{ __('Nhập mô tả ngắn') }}" icon="ti-message">
														</x-textarea>
													</div>
												</div>

												<!-- <div class="col-12">
													<div class="mb-3">
														<label class="control-label">{{ __('Mô tả') }}:</label>
														<textarea name="description" class="ckeditor visually-hidden">{{ old('description') }}</textarea>
													</div>
												</div>	 -->
								</div>
				</div>
</div>

