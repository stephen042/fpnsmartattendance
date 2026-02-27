<x-layouts::app :title="__('Overview')">

    <div class="space-y-6">

        <!-- Header -->
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Smart Attendance Dashboard</h1>
            <flux:button variant="primary" color="red">
                Stop Session Today
            </flux:button>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Card -->
            <div class="p-6 rounded-xl shadow bg-white dark:bg-neutral-900">
                <p class="text-sm opacity-70">Total Enrolled Students</p>
                <p class="text-3xl font-bold">120</p>
            </div>

            <div class="p-6 rounded-xl shadow bg-white dark:bg-neutral-900">
                <p class="text-sm opacity-70">Total Marked Today</p>
                <p class="text-3xl font-bold">85</p>
            </div>

            <div class="p-6 rounded-xl shadow bg-white dark:bg-neutral-900">
                <p class="text-sm opacity-70">Total Absent Today</p>
                <p class="text-3xl font-bold">35</p>
            </div>

            <div
                class="p-6 rounded-xl shadow bg-white dark:bg-zinc-900 border border-zinc-100 dark:border-zinc-800 transition-colors">
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Session Status</p>
                <p class="text-lg font-bold text-green-500 mb-2">Active</p>

                <div class="space-y-1 border-t border-zinc-50 dark:border-zinc-800 pt-2">
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-green-500"></div>
                        <p class="text-xs text-zinc-500 dark:text-zinc-500">
                            Started at <span class="font-semibold text-zinc-700 dark:text-zinc-300">9:00 AM</span>
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-zinc-300 dark:bg-zinc-600"></div>
                        <p class="text-xs text-zinc-500 dark:text-zinc-500">
                            Scheduled end <span class="font-semibold text-zinc-700 dark:text-zinc-300">4:00 PM</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Piechart --}}
        <div
            class="w-full max-w-2xl p-6 bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-zinc-200 dark:border-zinc-800 transition-colors">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Today's Attendance Overview</h3>
                    <p class="text-xs text-zinc-500">Real-time stats for selected criteria for Today only</p>
                </div>
                <span class="text-sm text-zinc-500 font-medium">Feb 24, 2026</span>
            </div>

            <div
                class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 p-4 bg-zinc-50 dark:bg-zinc-800/50 rounded-xl border border-zinc-100 dark:border-zinc-800">
                <div class="space-y-1">
                    <label class="text-[10px] uppercase font-bold text-zinc-400 tracking-wider">Students Level</label>
                    <select
                        class="w-full bg-white dark:bg-zinc-900 border-zinc-200 dark:border-zinc-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2 dark:text-white">
                        <option selected>Select Level</option>
                        <option value="ND1">ND1</option>
                        <option value="ND2">ND2</option>
                        <option value="HND1">HND 1</option>
                        <option value="HND2">HND 2</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] uppercase font-bold text-zinc-400 tracking-wider">Students Programme</label>
                    <select
                        class="w-full bg-white dark:bg-zinc-900 border-zinc-200 dark:border-zinc-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2 dark:text-white">
                        <option selected>Select Programme</option>
                        <option value="morning">Morning</option>
                        <option value="evening">Evening</option>
                        <option value="weekend">Weekend</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] uppercase font-bold text-zinc-400 tracking-wider">Specialization</label>
                    <select
                        class="w-full bg-white dark:bg-zinc-900 border-zinc-200 dark:border-zinc-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2 dark:text-white">
                        <option selected>Select Course Option</option>
                        <option value="swd">Software Development (SWD)</option>
                        <option value="ncc">Network & Cyber (NCC)</option>
                        <option value="cloud">Cloud Engineering</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button
                        class="w-full bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 hover:opacity-90 font-bold py-2 px-4 rounded-lg text-sm transition-all flex items-center justify-center gap-2">
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
                        <circle cx="18" cy="18" r="16" fill="none" stroke="currentColor"
                            stroke-width="4" class="text-zinc-100 dark:text-zinc-800"></circle>
                        <circle cx="18" cy="18" r="16" fill="none" stroke="#22c55e" stroke-width="4"
                            stroke-dasharray="70, 100" stroke-linecap="round"></circle>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-xl font-bold text-zinc-900 dark:text-white">70%</span>
                        <span class="text-[10px] uppercase text-zinc-400 font-bold tracking-tighter">Present</span>
                    </div>
                </div>

                <div class="flex-1 w-full space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                            <span class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Total Enrolled</span>
                        </div>
                        <span class="text-sm font-bold text-zinc-900 dark:text-white">200</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-green-500"></div>
                            <span class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Present Today</span>
                        </div>
                        <span class="text-sm font-bold text-zinc-900 dark:text-white">140</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-zinc-300 dark:bg-zinc-700"></div>
                            <span class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Absent / Not
                                Logged</span>
                        </div>
                        <span class="text-sm font-bold text-zinc-900 dark:text-white">60</span>
                    </div>

                    <div class="pt-2">
                        <div class="w-full bg-zinc-100 dark:bg-zinc-800 rounded-full h-1.5 overflow-hidden">
                            <div class="bg-green-500 h-full rounded-full transition-all duration-700"
                                style="width: 70%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Links --}}
        <div class="mt-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                <a href="{{ route('student-enrollment') }}"
                    class="group flex flex-col items-center justify-center p-5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl hover:border-blue-500 dark:hover:border-blue-500 transition-all duration-200 shadow-sm">
                    <div
                        class="w-12 h-12 mb-3 flex items-center justify-center rounded-xl bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-zinc-800 dark:text-zinc-200 text-center">Enroll Students</span>
                </a>

                <a href="{{ route('create-level') }}"
                    class="group flex flex-col items-center justify-center p-5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl hover:border-purple-500 dark:hover:border-purple-500 transition-all duration-200 shadow-sm">
                    <div
                        class="w-12 h-12 mb-3 flex items-center justify-center rounded-xl bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-zinc-800 dark:text-zinc-200 text-center">Create Levels</span>
                </a>

                <a href="#"
                    class="group flex flex-col items-center justify-center p-5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl hover:border-amber-500 dark:hover:border-amber-500 transition-all duration-200 shadow-sm">
                    <div
                        class="w-12 h-12 mb-3 flex items-center justify-center rounded-xl bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 011-1h1a2 2 0 100-4H7a1 1 0 01-1-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-zinc-800 dark:text-zinc-200 text-center">Create Level's
                        Option</span>
                </a>

                <a href="#"
                    class="group flex flex-col items-center justify-center p-5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl hover:border-emerald-500 dark:hover:border-emerald-500 transition-all duration-200 shadow-sm">
                    <div
                        class="w-12 h-12 mb-3 flex items-center justify-center rounded-xl bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-zinc-800 dark:text-zinc-200 text-center">Attendance Logs</span>
                </a>

            </div>
        </div>
    </div>
</x-layouts::app>
