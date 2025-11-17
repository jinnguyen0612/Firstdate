<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Trả lời câu hỏi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="question_id" class="form-label">Chọn câu hỏi:</label>
                        <x-select name="question_id" id="question_id" class="select2-bs5-ajax" data-url="{{ route('admin.search.select.question') }}"
                          :required="true">
                        </x-select>
                    </div>
                    <div class="mb-3">
                        <label for="answer" class="form-label">Câu trả lời:</label>
                        <x-input name="answer" class="form-control" id="answer"></x-input>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-default-cms" id="saveEvent">Lưu</button>
            </div>
        </div>
    </div>
</div>
