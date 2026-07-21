<x-layouts::app :title="__('Manage Courses')">
    <div class="max-w-5xl mx-auto space-y-8 pb-12">
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">Manage Courses</flux:heading>
                <flux:subheading>Create and manage courses offered</flux:subheading>
            </div>
        </div>

        {{-- Course Management Card --}}
        <livewire:admin.manage-courses.manage-courses />
    </div>


</x-layouts::app>
