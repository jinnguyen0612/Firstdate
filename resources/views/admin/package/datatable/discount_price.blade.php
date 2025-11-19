@if($discount_price != null && $discount_price > 0)
{{format_point($discount_price)}}
@else
-----
@endif