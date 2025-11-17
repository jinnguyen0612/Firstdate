<div class="container">
    <div class="row">
        @foreach($newBookings as $booking)
        <x-card-deal :code="$booking['data']['code']" 
                    bookingId="{{$booking['data']['id']}}"
                    :from="format_time($booking['from'], 'H:i')" 
                    :to="format_time($booking['to'], 'H:i')" 
                    :date="format_date($booking['data']['date'], 'd/m/Y')" 
                    userMale="{{ $booking['data']['user_male']['fullname'] }}"
                    userFemale="{{ $booking['data']['user_female']['fullname'] }}" />
        @endforeach 
    </div>
</div>
