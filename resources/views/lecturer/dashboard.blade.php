<x-layouts::lecturer :title="__('Manage Lecturers')">
    <div class="space-y-6">

        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-zinc-800 dark:text-white">Welcome {{auth()->user()->name}}</h1>
        </div>

        <livewire:lecturer.dashboard.profiledata />

        <livewire:lecturer.dashboard.session-control />

        <livewire:lecturer.dashboard.session-view-data />

    </div>
</x-layouts::lecturer>
