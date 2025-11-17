 @if (isset($partner))
     <x-link :href="route('admin.partner.edit', $partner['id'])" :title="$partner['name']" class="text-decoration-none" />
 @else
     Không có
 @endif
