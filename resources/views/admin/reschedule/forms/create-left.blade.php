<div class="col-12 col-md-9">
    <!-- Thông tin dời buổi học -->
    <div class="card mb-3">
        <div class="card-header">
            <h2 class="mb-0">{{ __('Thông tin dời buổi học') }}</h2>
        </div>
        <div class="row card-body">

            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-user"></i> {{ __('Lớp học') }}:<span
                            class="text-danger">*</span></label>
                    <x-select style="width: 100%;" name="classroom_id" class="select2-bs5-ajax" data-url="{{ route('admin.search.select.classroom') }}" id="classroom_id">
                    </x-select>
                </div>
            </div>
            <div class="col-12">
                <div class="mb-3">
                    <label for=""><i class="ti ti-building"></i> {{ __('Buổi học cần dời') }} <span
                            class="text-danger">*</span></label>
                    <x-select name="old_session_id" id="old_session_id" class="select2-bs5-ajax" data-url=""
                            :required="true">
                    </x-select>
                </div>
            </div>

            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-users"></i>
                        {{ __('Ngày học bù') }}:</label>
                    <x-input id="date" name="date" type="date" :value="old('date')"/>
                </div>
            </div>
            
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-users"></i>
                        {{ __('Thời gian bắt đầu') }}:</label>
                    <x-input id="start" name="start" type="time" :value="old('start')"/>
                </div>
            </div>
            
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-users"></i>
                        {{ __('Thời gian kết thúc') }}:</label>
                    <x-input id="end" name="end" type="time" :value="old('end')"/>
                </div>
            </div>

            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-users"></i>
                        {{ __('Lý do xin dời') }}:</label>
                    <x-textarea id="content" name="content" rows="3" placeholder="{{ __('Lý do xin dời') }}"></x-textarea>
                </div>
            </div>

        </div>
        
    </div>
</div>
