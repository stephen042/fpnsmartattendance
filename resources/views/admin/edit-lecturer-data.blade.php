<x-layouts::app :title="__('Update Lecturers')">
    <div class="max-w-6xl mx-auto space-y-8 pb-12">

        {{-- Header Section --}}
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">Update Lecturers</flux:heading>
                <flux:subheading>Update Deparment Lecturers Details</flux:subheading>
            </div>
        </div>

        <flux:card class="bg-zinc-50/80 dark:bg-zinc-900/50 border-zinc-200/60 shadow-sm">
            <div class="flex items-center gap-2 mb-6">
                <flux:icon name="user-group" variant="outline" class="text-zinc-400" />
                <flux:heading size="lg">Update Lecturer Details</flux:heading>
            </div>

            {{-- Registration Form --}}
            <livewire:admin.manage-lecturers.edit-lecturer :id="request()->route('id')" />
        </flux:card>
    </div>
</x-layouts::app>
