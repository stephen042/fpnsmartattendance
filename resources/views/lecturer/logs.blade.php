<x-layouts::lecturer :title="__('Class Details')">
    <div class="space-y-6">
        <flux:button variant="ghost" size="sm" color="zinc" onclick="window.history.back()"
            icon="arrow-left">
            Back 
        </flux:button>

        <flux:heading size="xl" level="1">Full Attendance Report</flux:heading>

        <livewire:lecturer.attendance-logs.session-history />

    </div>
</x-layouts::lecturer>
