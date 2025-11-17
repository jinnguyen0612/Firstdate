<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header justify-content-center">
            <h2 class="mb-0">{{ __('Thông tin danh mục') }}</h2>
        </div>
        <div class="row card-body">
            <!-- title -->
            <div class="col-md-12 col-sm-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-category"></i>
                        {{ __('Tên danh mục') }}: <span class="text-danger">*</span></label>
                    <x-input name="title" :value="old('title')" :required="true"
                        placeholder="{{ __('Tên danh mục') }}" />
                </div>
            </div>
        </div>
    </div>
</div>
