<x-layouts::app :title="__('Manage Lecturers')">
    <div class="max-w-6xl mx-auto space-y-8 pb-12">

        {{-- Header Section --}}
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">Manage Lecturers</flux:heading>
                <flux:subheading>Register and oversee Deparment Lecturers and their assignments.</flux:subheading>
            </div>
        </div>

        {{-- Registration Card --}}
        <livewire:admin.manage-lecturers.create-lecturer />
    </div>
</x-layouts::app>
