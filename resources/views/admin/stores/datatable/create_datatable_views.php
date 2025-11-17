<?php

$directory = 'resources/views/admin/users/datatable';
$files = [
    'fullname.blade.php' => '<x-link :href="route(\'admin.user.edit\', $id)" :title="$fullname"/>',
    'email.blade.php' => '<span>{{ $email }}</span>',
    'phone.blade.php' => '<span>{{ $phone }}</span>',
    'active.blade.php' => '<span class="{{ $active ? \'text-success\' : \'text-danger\' }}">{{ $active ? \'Hoạt động\' : \'Không hoạt động\' }}</span>',
    'gender.blade.php' => '<span>{{ $gender }}</span>',
    'avatar.blade.php' => '<img src="{{ asset($avatar) }}" alt="avatar" class="img-fluid" width="100" height="100">',
    'max_sound_intensity.blade.php' => '<span>{{ $max_sound_intensity }}</span>',
    'max_speed.blade.php' => '<span>{{ $max_speed }}</span>',
    'created_at.blade.php' => '<span>{{ $created_at }}</span>',
    'action.blade.php' => '<x-button.modal-delete class="btn-icon" data-route="{{ route(\'admin.user.delete\', $id) }}">
  <i class="ti ti-trash"></i>
 </x-button.modal-delete>',
];

// Create directory if it doesn't exist
if (!is_dir($directory)) {
    mkdir($directory, 0755, true);
}

// Create files with content
foreach ($files as $filename => $content) {
    file_put_contents("$directory/$filename", $content);
}

echo "Files created successfully.";
