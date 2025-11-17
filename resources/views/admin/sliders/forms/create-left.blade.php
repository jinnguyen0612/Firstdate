<div class="col-12 col-md-9">
				<div class="card">
								<div class="card-header justify-content-center">
												<h2 class="mb-0">{{ __('Thông tin slider') }}</h2>
								</div>
								<div class="row card-body">
												<!-- name -->
												<div class="col-12">
																<div class="mb-3">
																				<label class="control-label"><i class="ti ti-slideshow"></i> {{ __('Tên slider') }}: <span
																												class="text-danger">*</span></label>
																				<x-input name="name" :value="old('name')" :required="true" placeholder="{{ __('Tên slider') }}" />
																</div>
												</div>
												<!-- name -->
												<div class="col-12">
																<div class="mb-3">
																				<label class="control-label"><i class="ti ti-key"></i> {{ __('Key') }}: <span
																												class="text-danger">*</span></label>
																				<x-input name="plain_key" :value="old('plain_key')" :required="true"
																								placeholder="{{ __('Định danh slider') }}" />
																</div>
												</div>
												<!-- desc -->
												<div class="col-12">
																<div class="mb-3">
																				<label class="control-label"><i class="ti ti-file-description"></i> {{ __('Mô tả') }}:</label>
																				<x-textarea name="desc">{{ old('desc') }}</x-textarea>
																</div>
												</div>
								</div>
				</div>
</div>
