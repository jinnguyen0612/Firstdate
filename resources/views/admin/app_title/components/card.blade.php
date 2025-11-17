<div class="card rounded text-center overflow-hidden border-0 shadow col-md-6 col-12 gap-1 mt-2">
    <div class="p-2 rounded" style="background: linear-gradient(to bottom, rgb(242, 24, 90), rgb(240, 24, 60));">
        <input type="hidden" name="titles[{{ $index }}][id]" value="{{ $title->id }}">
        <div class="text-white">
            <div class="col-12">
                    <label class="control-label">{{ $title->key }}</label>
            </div>
            <div class="col-12">
                    <label class="control-label">{{ $title->name }}</label>
            </div>
        </div>
    </div>
    <div class="card-body bg-dark text-white">
        <textarea name="titles[{{ $index }}][value]" class="ckeditor visually-hidden">{{ $title->value }}</textarea>
    </div>
</div>