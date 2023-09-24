@captureSlots([
    'detail',
])
@php
    $user = Auth::user();
@endphp
<a href="{{ url('/admin/profile/'.$user->id.'/edit') }}"> 
    <x-filament-support::dropdown.header
        :attributes="\Filament\Support\prepare_inherited_attributes($attributes)->merge($slots)"
        :dark-mode="config('filament.dark_mode')"
    >
        {{ $slot }}
    </x-filament-support::dropdown.header>
</a>
