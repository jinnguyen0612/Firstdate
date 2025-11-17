@if ($gender !== null)
<span>{{ App\Enums\User\Gender::getDescription($gender) }}</span>
@endif