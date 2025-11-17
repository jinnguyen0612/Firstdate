<div class="container">
    <div class="row">
        @foreach($confirmBookings as $booking)
        @php
            $from = $booking->deal->dealDateOptions->where('is_chosen', 1)->first()->from ?? null;
            $to = $booking->deal->dealDateOptions->where('is_chosen', 1)->first()->from ?? null;
        @endphp
        <x-card-deal :code="$booking->code" 
                    bookingId="{{ $booking->id }}"
                    :status="$booking->status" 
                    time="{{ $booking->time ? format_time($booking->time, 'H:i') : null }}" 
                    :from="format_time($from, 'H:i')" 
                    :to="format_time($to, 'H:i')"
                    :date="format_date($booking->date, 'd/m/Y')" 
                    userMale="{{ $booking->user_male->fullname }}"
                    userFemale="{{ $booking->user_female->fullname }}" />
        @endforeach
    </div>
</div>
