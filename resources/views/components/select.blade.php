<select {{ $attributes->class(['form-select'])->merge($isRequired()) }} style="width:100%;">
    {{ $slot }}
</select>
