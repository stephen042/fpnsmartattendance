<x-layouts::super_admin.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts::super_admin.sidebar>
