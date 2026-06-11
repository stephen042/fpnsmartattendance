<x-layouts::app :title="__('Overview')">

    <div class="space-y-6">

        <!-- Header -->
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Smart Attendance Dashboard</h1>
            {{-- <flux:button variant="primary" color="red">
                Stop Session Today
            </flux:button> --}}
        </div>

        <livewire:admin.dashboard.overview />
        
        {{-- Piechart --}}
        <livewire:admin.dashboard.chart />
        
    </div>
</x-layouts::app>
