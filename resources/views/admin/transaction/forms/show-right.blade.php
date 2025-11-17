@php
use App\Enums\Transaction\TransactionStatus;
use App\Enums\Transaction\TransactionType;
@endphp
    <div class="col-12 col-md-3">
        @if($isAdmin && $transaction->status == TransactionStatus::Pending->value)
        <div class="card mb-3">
            <div class="card-header">
                <i class="ti ti-playstation-circle"></i>
                <span class="ms-2">{{ __('Thao tác') }}</span>
            </div>
            <div class="card-body d-flex justify-content-between p-2">
                <x-button.submit :title="__('Cập nhật')" />
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <span><i class="ti ti-toggle-right me-2"></i>{{ __('Trạng thái') }}</span>
            </div>
            <div class="card-body p-2">
                <x-select class="form-select" name="status" :required="true">
                    @foreach ($status as $key => $value)
                        <x-select-option :option="$transaction->status" :value="$key" :title="$value" />
                    @endforeach
                </x-select>
            </div>
        </div>
        @endif
    </div>
