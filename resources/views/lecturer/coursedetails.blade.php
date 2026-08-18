<x-layouts::lecturer :title="__('Class Details')">
    <div class="space-y-6">
        <flux:button variant="ghost" size="sm" color="zinc" onclick="window.history.back()" icon="arrow-left">
            Back
        </flux:button>


        <livewire:lecturer.attendance-logs.course-details :course="$course" />
    </div>
</x-layouts::lecturer>
