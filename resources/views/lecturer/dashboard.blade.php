<x-layouts::lecturer :title="__('Manage Lecturers')">
    <div class="space-y-6">

        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-zinc-800 dark:text-white">Lecturer's Attendance Dashboard</h1>
        </div>

        <flux:card class="bg-zinc-50/80 dark:bg-zinc-900/50 border-zinc-200/60 shadow-sm">
            <div class="">
                <div class="flex items-end justify-between mb-6">
                    <div>
                        <p class="text-sm font-medium opacity-70">Course(s) Assigned</p>
                        <p class="text-2xl font-bold mt-1 ">3</p>
                    </div>
                    <flux:badge variant="flat" color="blue">First Semester</flux:badge>
                </div>

                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 border-zinc-200 dark:border-zinc-800 pt-6">

                    <div
                        class="p-4 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-100 dark:border-zinc-800 shadow-sm flex flex-col justify-between">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h4 class="font-bold text-sm text-zinc-800 dark:text-zinc-200">Backend Development 2
                                </h4>
                                <span class="text-xs text-zinc-500">SWD413 | Practical</span>
                            </div>
                            <flux:badge size="sm" variant="flat" color="zinc">120 Students</flux:badge>
                        </div>
                        <div class="space-y-2">
                            <flux:badge size="sm" variant="flat" color="zinc">5 classes</flux:badge>
                            <div
                                class="flex justify-between text-[10px] uppercase font-bold text-zinc-400 tracking-wider">
                                <span>Attendance Avg.</span>
                                <span class="text-emerald-500">85%</span>
                            </div>
                            <div class="w-full bg-zinc-100 dark:bg-zinc-800 rounded-full h-1.5">
                                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: 85%"></div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="p-4 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-100 dark:border-zinc-800 shadow-sm flex flex-col justify-between">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h4 class="font-bold text-sm text-zinc-800 dark:text-zinc-200">Data Structures</h4>
                                <span class="text-xs text-zinc-500">SWD416 | Theory</span>
                            </div>
                            <flux:badge size="sm" variant="flat" color="zinc">95 Students</flux:badge>
                        </div>
                        <div class="space-y-2">
                            <flux:badge size="sm" variant="flat" color="zinc">8 classes</flux:badge>
                            <div
                                class="flex justify-between text-[10px] uppercase font-bold text-zinc-400 tracking-wider">
                                <span>Attendance Avg.</span>
                                <span class="text-blue-500">92%</span>
                            </div>
                            <div class="w-full bg-zinc-100 dark:bg-zinc-800 rounded-full h-1.5">
                                <div class="bg-blue-500 h-1.5 rounded-full" style="width: 92%"></div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="p-4 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-100 dark:border-zinc-800 shadow-sm flex flex-col justify-between">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h4 class="font-bold text-sm text-zinc-800 dark:text-zinc-200">Communication In English
                                </h4>
                                <span class="text-xs text-zinc-500">GNS401 | Theory</span>
                            </div>
                            <flux:badge size="sm" variant="flat" color="zinc">110 Students</flux:badge>
                        </div>
                        <div class="space-y-2">
                            <flux:badge size="sm" variant="flat" color="zinc">6 classes</flux:badge>
                            <div
                                class="flex justify-between text-[10px] uppercase font-bold text-zinc-400 tracking-wider">
                                <span>Attendance Avg.</span>
                                <span class="text-amber-500">68%</span>
                            </div>
                            <div class="w-full bg-zinc-100 dark:bg-zinc-800 rounded-full h-1.5">
                                <div class="bg-amber-500 h-1.5 rounded-full" style="width: 68%"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </flux:card>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <flux:card class="bg-white dark:bg-zinc-900 border-zinc-200 dark:border-zinc-800 shadow-sm">
                    <div>
                        <div class="flex items-center justify-between">
                            <div>
                                <flux:heading size="lg">Class Session Control</flux:heading>
                                <flux:subheading>Manage your current classroom presence.</flux:subheading>
                            </div>
                            <flux:badge color="emerald" variant="flat" class="animate-pulse">Active: SWD413</flux:badge>
                        </div>

                        <div class="mt-6 space-y-6">
                            <flux:select label="Change Active Course" placeholder="Select a course to switch...">
                                <flux:select.option>Backend Development 2 (SWD413)</flux:select.option>
                                <flux:select.option>Data Structures (SWD416)</flux:select.option>
                            </flux:select>

                            <div
                                class="flex flex-col md:flex-row gap-8 items-center py-4 bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl p-4 border border-dashed border-zinc-200 dark:border-zinc-700">
                                {{-- <div class="p-3 bg-white dark:bg-zinc-900 rounded-xl shadow-sm">
                                    <div class="w-28 h-28 flex items-center justify-center">
                                        <flux:icon name="qr-code" variant="outline"
                                            class="size-20 text-zinc-800 dark:text-zinc-200" />
                                    </div>
                                </div> --}}

                                <div class="flex-1 w-full space-y-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-zinc-500">Attendance
                                        Entry
                                        Code</label>
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="flex-1 bg-white dark:bg-zinc-900 py-3 px-4 rounded-lg border border-zinc-200 dark:border-zinc-700 text-center">
                                            <span
                                                class="text-2xl font-mono font-black tracking-widest text-emerald-600">B2-X9K4L2</span>
                                        </div>
                                        <flux:button icon="clipboard" variant="ghost" />
                                    </div>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <flux:button variant="primary" class="flex-1" icon="play-circle">Start New Session
                                </flux:button>
                                {{-- info --}}
                            </div>
                            <span class="text-sm font-medium text-zinc-500">All other Sessions registered under you will
                                be ended.</span>
                        </div>
                    </div>
                </flux:card>
            </div>

            <div class="space-y-6">
                <flux:card class="bg-emerald-50 dark:bg-transparent border-emerald-100 dark:border-emerald-900/30">
                    <div class="flex flex-col gap-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-emerald-500 rounded-lg">
                                <flux:icon name="users" class="text-white size-5" />
                            </div>
                            <div>
                                <p class="text-sm font-bold text-emerald-900 dark:text-emerald-400">Live Check-ins</p>
                                <p class="text-3xl font-black text-emerald-700">42 <span
                                        class="text-sm font-normal opacity-60">/ 120</span></p>
                            </div>
                        </div>
                        <div class="w-full bg-emerald-200 dark:bg-emerald-800 rounded-full h-2">
                            <div class="bg-emerald-600 h-2 rounded-full" style="width: 35%"></div>
                        </div>
                        <p class="text-[10px] text-emerald-600 dark:text-emerald-500 font-medium italic">Last check-in:
                            2 mins ago</p>
                    </div>
                </flux:card>

                <flux:card class="border-zinc-200 dark:border-zinc-800">
                    <flux:button variant="danger" class="flex-1" icon="stop-circle">End Current Session
                    </flux:button>
                </flux:card>
            </div>
        </div>

        <flux:card class="bg-white dark:bg-zinc-900 border-zinc-200/60 shadow-sm mt-6">
            <div
                class=" border-b border-zinc-100 dark:border-zinc-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <flux:heading>Session History</flux:heading>
                    <flux:subheading>Review and export past class attendance records.</flux:subheading>
                </div>

                <div class="flex items-center gap-3">
                    <flux:input icon="magnifying-glass" placeholder="Search course or date..." class="max-w-xs" />
                    <flux:button icon="document-arrow-down" variant="outline" size="sm">Download CSV
                    </flux:button>
                </div>
            </div>
            <hr style="margin:5px 3px" />

            <flux:table>
                <flux:table.columns>
                    <flux:table.column sortable>Date & Time</flux:table.column>
                    <flux:table.column>Course</flux:table.column>
                    <flux:table.column align="center">Attendance</flux:table.column>
                    <flux:table.column align="center">Action</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    <flux:table.row>
                        <flux:table.cell class="text-zinc-800 dark:text-zinc-200 font-medium">
                            <div class="flex flex-col gap-2">
                                <div>
                                    April 20, 2026
                                    <span class="block text-xs font-normal text-zinc-500">
                                        09:00 AM - 11:00 AM
                                    </span>
                                </div>

                                <div class="flex">
                                    <flux:badge color="emerald" variant="flat" class="animate-pulse">Active: SWD413
                                    </flux:badge>
                                </div>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell>
                            <div class="flex flex-col">
                                <span class="font-medium">Backend Development 2</span>
                                <span class="text-xs text-zinc-500 uppercase">SWD413 • Practical</span>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell align="center">
                            <flux:badge color="zinc" variant="outline">112 / 120</flux:badge>
                        </flux:table.cell>
                        <flux:table.cell align="center">
                            <flux:button link :href="route('lecturer.classdetails', [1])" variant="ghost"
                                size="sm" icon="eye">Full Report</flux:button>
                        </flux:table.cell>
                    </flux:table.row>
                    <flux:table.row>
                        <flux:table.cell class="text-zinc-800 dark:text-zinc-200 font-medium">
                            <div class="flex flex-col gap-2">
                                <div>
                                    April 20, 2026
                                    <span class="block text-xs font-normal text-zinc-500">
                                        09:00 AM - 11:00 AM
                                    </span>
                                </div>

                                <div class="flex">
                                    <flux:badge color="red" variant="flat" class="animate-pulse">Closed: SWD418
                                    </flux:badge>
                                </div>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell>
                            <div class="flex flex-col">
                                <span class="font-medium">Frontend Development 2</span>
                                <span class="text-xs text-zinc-500 uppercase">SWD418 • Theory</span>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell align="center">
                            <flux:badge color="zinc" variant="outline">12 / 120</flux:badge>
                        </flux:table.cell>
                        <flux:table.cell align="center">
                            <flux:button link :href="route('lecturer.classdetails', [1])" variant="ghost"
                                size="sm" icon="eye">Full Report</flux:button>
                        </flux:table.cell>
                    </flux:table.row>
                </flux:table.rows>
            </flux:table>
        </flux:card>

    </div>
</x-layouts::lecturer>
