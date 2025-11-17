@if ($district && $province)
<span>{{ $district['name'] .', '. $province['name'] }}</span>
@else
<span>--</span>
@endif