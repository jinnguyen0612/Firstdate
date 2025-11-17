<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header justify-content-center">
            <h2 class="mb-0">{{ __('Thông tin Câu hỏi hỗ trợ') }}</h2>
        </div>
        <div class="row card-body">
            <!-- title -->
            <div class="col-md-12 col-sm-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-category"></i> {{ __('Tiêu đề') }}:</label>
                    <x-input name="title" :value="$category->title" :required="true" placeholder="{{ __('Tiêu đề') }}" />
                </div>
            </div>

            <!-- title -->
            <div class="col-md-12 col-sm-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-category"></i> {{ __('Nội dung') }}:</label>
                    <x-textarea class="ckeditor visually-hidden" name="content" :required="true"
                        placeholder="{{ __('Nội dung') }}" rows="5">
                        {{ $category->content }}
                    </x-textarea>
                </div>
            </div>

        </div>
    </div>
</div>
