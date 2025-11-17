<a href="{{ route('admin.partner.edit', $partner_id) }}" title="{{ $partner['name'] }}">
    {{ $partner['address'] . ', ' . $partner['district']['name'] . ', ' . $partner['province']['name'] }}
</a>
