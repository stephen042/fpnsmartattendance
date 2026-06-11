<div
    class="w-full max-w-2xl p-6 bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-zinc-200 dark:border-zinc-800 transition-colors">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Today's Attendance Overview</h3>
            <p class="text-xs text-zinc-500">Real-time stats for selected criteria for Today only</p>
        </div>
        <span class="text-sm text-zinc-500 font-medium">{{ now()->format('M d, Y') }}</span>
    </div>

    <div
        class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 p-4 bg-zinc-50 dark:bg-zinc-800/50 rounded-xl border border-zinc-100 dark:border-zinc-800">
        <div class="space-y-1">
            <label class="text-[10px] uppercase font-bold text-zinc-400 tracking-wider">Students Level</label>
            <select wire:model="level_id">
                <option value="">All Levels</option>

                @foreach ($levels as $level)
                    <option value="{{ $level->id }}">
                        {{ $level->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="space-y-1">
            <label class="text-[10px] uppercase font-bold text-zinc-400 tracking-wider">Students
                Programme</label>
            <select wire:model="programme_id">
                <option value="">All Programmes</option>

                @foreach ($programmes as $programme)
                    <option value="{{ $programme->id }}">
                        {{ $programme->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="space-y-1">
            <label class="text-[10px] uppercase font-bold text-zinc-400 tracking-wider">Specialization (<span
                    class="text-red-500 lowercase">Optional</span>)</label>
            <select wire:model="course_option_id">
                <option value="">All Options</option>

                @foreach ($courseOptions as $option)
                    <option value="{{ $option->id }}">
                        {{ $option->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-end">
            <button
                class="w-full bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 hover:opacity-90 font-bold py-2 px-4 rounded-lg text-sm transition-all flex items-center justify-center gap-2" wire:click="applyFilters">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Apply Filters
            </button>
        </div>
    </div>

    <div class="flex flex-col md:flex-row items-center gap-8">
        <div class="relative w-32 h-32 shrink-0">
            <svg viewBox="0 0 36 36" class="w-full h-full transform -rotate-90">
                <circle cx="18" cy="18" r="16" fill="none" stroke="currentColor" stroke-width="4"
                    class="text-zinc-100 dark:text-zinc-800"></circle>
                <circle cx="18" cy="18" r="16" fill="none" stroke="#22c55e" stroke-width="4"
                    stroke-dasharray="{{ $attendancePercentage }}, 100" stroke-linecap="round"></circle>
            </svg>
            <div class="absolute inset-0 flex flex-col items-center justify-center">
                <span class="text-xl font-bold text-zinc-900 dark:text-white">{{ $attendancePercentage }}%</span>
                <span class="text-[10px] uppercase text-zinc-400 font-bold tracking-tighter">Present</span>
            </div>
        </div>

        <div class="flex-1 w-full space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                    <span class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Total Enrolled</span>
                </div>
                <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ number_format($totalStudents) }}</span>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-green-500"></div>
                    <span class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Present Today</span>
                </div>
                <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ number_format($presentStudents) }}</span>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-zinc-300 dark:bg-zinc-700"></div>
                    <span class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Absent / Not
                        Logged</span>
                </div>
                <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ number_format($absentStudents) }}</span>
            </div>

            <div class="pt-2">
                <div class="w-full bg-zinc-100 dark:bg-zinc-800 rounded-full h-1.5 overflow-hidden">
                    <div class="bg-green-500 h-full rounded-full transition-all duration-700" style="width: {{ $attendancePercentage }}%"></div>
                </div>
            </div>
        </div>
    </div>
</div>
