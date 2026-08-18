<x-layouts::lecturer :title="__('Class Details')">
    <div class="space-y-6">
        <flux:button variant="ghost" size="sm" color="zinc" onclick="window.history.back()" icon="arrow-left">
            Back
        </flux:button>

        <livewire:lecturer.dashboard.session-view-datadetials :session="$session" />
        
    </div>
</x-layouts::lecturer>
