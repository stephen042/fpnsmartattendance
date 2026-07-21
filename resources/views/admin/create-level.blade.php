<x-layouts::app :title="__('Create Level')">
    <div class="max-w-5xl mx-auto space-y-8 pb-12">

        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">Academic Configuration</flux:heading>
                <flux:subheading>Manage school levels and study programmes.</flux:subheading>
            </div>
        </div>

        {{-- Level Card --}}
        <livewire:admin.create-level-and-options.create-level />


        {{-- Programme Card --}}
        <livewire:admin.create-level-and-options.create-programme />

        {{-- Course Option Card --}}
        <livewire:admin.create-level-and-options.create-course-option />
    </div>
</x-layouts::app>
