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
																				<x-input-email id="emailInput" name="email" :value="$user->email" :disabled="!$isAdmin"/>
																</div>
												</div>

												<div class="col-md-6 col-12">
																<div class="mb-3">
																				<label class="control-label"><i class="ti ti-phone"></i>
																								{{ __('Số điện thoại đăng nhập') }}:</label>
																				<x-input-phone name="phone" :value="$user->phone"
																								placeholder="{{ __('Số điện thoại đăng nhập') }}" :disabled="!$isAdmin"/>
																</div>
												</div>

												<div class="col-md-6 col-12">
																<div class="mb-3">
																				<label class="control-label"><i class="ti ti-key"></i> {{ __('Mật khẩu') }}:</label>
																				<x-input-password name="password" :disabled="!$isAdmin"/>
																</div>
												</div>

												<div class="col-md-6 col-12">
																<div class="mb-3">
																				<label class="control-label"><i class="ti ti-key"></i> {{ __('Xác nhận mật khẩu') }}:</label>
																				<x-input-password name="password_confirmation" data-parsley-equalto="input[name='password']"
																								data-parsley-equalto-message="{{ __('Mật khẩu không khớp.') }}" :disabled="!$isAdmin"/>
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
																				<x-input name="name" :value="$user->name" placeholder="{{ __('Tên Đối tác') }}" :disabled="!$isAdmin"/>
																</div>
												</div>
												
												<div class="col-md-6 col-12">
																<div class="mb-3">
																	<label class="control-label"><i class="ti ti-user"></i> {{ __('Loại đối tác') }}:</label>
																	<x-select style="width: 100%;" name="partner_category_id" class="select2-bs5-ajax" :data-url="route('admin.search.select.partner_category')" id="partner_category_id" :disabled="!$isAdmin">
																		<x-select-option :option="$user->partner_category_id"
																						:value="$user->partner_category_id"
																						:title="$user->partner_category->name" />
																	</x-select>
																</div>
												</div>

												{{-- address --}}
												<div class="col-12">
																<div class="mb-3">
																				<label class="control-label"><i class="ti ti-user-edit"></i> {{ __('Địa chỉ') }}:</label>
																				<x-input name="address" :value="$user->address" placeholder="{{ __('Số nhà, tên đường, phường/xã') }}" :disabled="!$isAdmin"/>
																</div>
												</div>

												<div class="col-12">
													<div class="mb-3">
														<x-input-pick-address :label="__('Địa chỉ nơi ở hiện tại')" province="province" 
																				:valueProvince="$user->province" 
																				district="district" 
																				:valueDistrict="$user->district" 
																				:placeholder="__('Địa chỉ nơi ở hiện tại')" :required="true" :disabled="!$isAdmin"/>
													</div>
												</div>
												
												{{-- Hidden fields --}}
												<input type="hidden" name="lat" :value="$user->lat">
												<input type="hidden" name="lng" :value="$user->lng">
												{{-- <input type="hidden" name="province" :value="$user->province->name" >
												<input type="hidden" name="district" :value="$user->district->name"> --}}

												<div class="col-12">
													<div class="mb-3">
														<label class="control-label"><i class="ti ti-bookmark"></i> {{ __('Mô tả ngắn') }}:</label>
														<x-textarea maxlength="500" name="description" :required="false"
																	placeholder="{{ __('Nhập mô tả ngắn') }}" icon="ti-message" :disabled="!$isAdmin">
																	{{ $user->description }}
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

