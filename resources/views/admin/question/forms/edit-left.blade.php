<div class="col-12 col-md-9 question-form">
    <div class="card mb-3">
        <div class="card-header justify-content-between">
            <h2 class="mb-0"><i class="ti ti-message-2-question"></i>{{ __(' Câu hỏi') }}</h2>
            <div class="align-items-center d-flex">
                <div>{{ __('Bắt buộc') }}</div>
                <div class="mx-2 align-items-end">
                    <label class="heart-switch">
                        <input type="hidden" name="is_required" value="0">
                        <input type="checkbox" name="is_required" value="1" {{ $question->is_required == 1 ? 'checked' : '' }} {{ !$isAdmin ? 'disabled' : '' }}>
                        <svg viewBox="0 0 33 23" fill="white">
                            <path d="M23.5,0.5 C28.4705627,0.5 32.5,4.52943725 32.5,9.5 C32.5,16.9484448 21.46672,22.5 16.5,22.5 C11.53328,22.5 0.5,16.9484448 0.5,9.5 C0.5,4.52952206 4.52943725,0.5 9.5,0.5 C12.3277083,0.5 14.8508336,1.80407476 16.5007741,3.84362242 C18.1491664,1.80407476 20.6722917,0.5 23.5,0.5 Z"></path>
                        </svg>
                    </label>
                </div>
            </div>
        </div>
        <div class="card-body p-2">
            <input id="question-input" name="content" type="text" required placeholder="Điền câu hỏi của bạn" {{ !$isAdmin ? 'disabled' : '' }}/>
            <div id="choices-container"></div>
            <button type="button" id="add-choice-btn" style="{{ !$isAdmin ? 'opacity: 0; pointer-events: none;' : '' }}">Thêm lựa chọn</button>
        </div>
    </div> 
</div>
