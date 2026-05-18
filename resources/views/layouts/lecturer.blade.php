<x-layouts::lecturer.lecturer-sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts::lecturer.lecturer-sidebar>
