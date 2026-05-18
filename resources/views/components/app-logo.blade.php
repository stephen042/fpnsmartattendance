@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand {{ $attributes }}>
        <x-slot name="logo">
            <x-app-logo-icon class="size-6 text-white dark:text-black" />
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand {{ $attributes }}>
        <x-slot name="logo">
            <x-app-logo-icon class="size-6 text-white dark:text-black" />
        </x-slot>
    </flux:brand>
@endif
