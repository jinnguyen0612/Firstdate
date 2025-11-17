<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header justify-content-center">
            <h2 class="mb-0">{{ __('Thông tin Câu hỏi hỗ trợ') }}</h2>
        </div>
        <div class="row card-body">
            <!-- title -->
            <div class="col-md-12 col-sm-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-category"></i>
                        {{ __('Tiêu đề') }}: <span class="text-danger">*</span></label>
                    <x-input name="title" :value="old('title')" :required="true"
                        placeholder="{{ __('Tiêu đề') }}" />
                </div>
            </div>

            <div class="col-md-12 col-sm-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-category"></i>
                        {{ __('Nội dung') }}: <span class="text-danger">*</span></label>
                    <x-textarea class="ckeditor visually-hidden" name="content" :value="old('content')" :required="true"
                        placeholder="{{ __('Nội dung') }}" rows="5" />
                </div>
            </div>


        </div>
    </div>
</div>
