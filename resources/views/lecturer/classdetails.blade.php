<x-layouts::lecturer :title="__('Class Details')">
    <div class="space-y-6">
        <flux:button variant="ghost" size="sm" color="zinc" onclick="window.history.back()"
            icon="arrow-left">
            Back 
        </flux:button>
        <flux:card class="bg-zinc-50/80 dark:bg-zinc-900/50 border-zinc-200/60 shadow-sm">
            <div class="">
                <div class="flex items-end justify-between mb-6">
                    <div>
                        <flux:badge size="lg" color="emerald" variant="flat" class="animate-pulse">Active: SWD413
                        </flux:badge>
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
                                <span>Attendance Avg. For This Class Session</span>
                                <span class="text-emerald-500">85%</span>
                            </div>
                            <div class="w-full bg-zinc-100 dark:bg-zinc-800 rounded-full h-1.5">
                                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: 85%"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </flux:card>

        <flux:card class="bg-white dark:bg-zinc-900 border-zinc-200/60 shadow-sm mt-6">
            <flux:table>
                <flux:table.columns>
                    <flux:table.column sortable>Student Info</flux:table.column>
                    <flux:table.column>Identifiers</flux:table.column>
                    <flux:table.column align="center">Sign-in Time</flux:table.column>
                    <flux:table.column align="right">Actions</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    {{-- Loop starts here --}}
                    <flux:table.row>
                        {{-- Student Name --}}
                        <flux:table.cell>
                            <div class="flex items-center gap-3">
                                <flux:avatar initials="AS" size="xs" class="bg-zinc-100 dark:bg-zinc-800" />
                                <div class="flex flex-col">
                                    <span class="font-semibold text-zinc-800 dark:text-zinc-200 uppercase">Ani Makuochukwu
                                        Stephen</span>
                                    <span class="text-[10px] text-emerald-600 font-medium">Verified Geolocation</span>
                                </div>
                            </div>
                        </flux:table.cell>

                        {{-- Application & Matric Numbers --}}
                        <flux:table.cell>
                            <div class="flex flex-col text-xs">
                                <span
                                    class="text-zinc-700 dark:text-zinc-300 font-mono">FPN/HNDE/2024/0000000014483</span>
                                <span class="text-zinc-500 text-[10px] uppercase">Matric: FPN/CS/2024/001</span>
                            </div>
                        </flux:table.cell>

                        {{-- Specific Time of Sign-in --}}
                        <flux:table.cell align="center">
                            <div class="flex flex-col items-center">
                                <span class="text-sm font-medium text-zinc-800 dark:text-zinc-200">09:05 AM</span>
                                <span class="text-[9px] text-zinc-400 uppercase tracking-tighter">2 mins after
                                    start</span>
                            </div>
                        </flux:table.cell>

                        {{-- Action: Suspend Student --}}
                        <flux:table.cell align="right">
                            <div class="flex justify-end items-center gap-2">

                                <flux:button variant="subtle" size="sm" color="red" icon="user-minus"
                                    class="hover:bg-red-100 dark:hover:bg-red-900/40" style="color: #ef4444">
                                    Suspend
                                </flux:button>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                    <flux:table.row>
                        {{-- Student Name --}}
                        <flux:table.cell>
                            <div class="flex items-center gap-3">
                                <flux:avatar initials="PO" size="xs" class="bg-zinc-100 dark:bg-zinc-800" />
                                <div class="flex flex-col">
                                    <span class="font-semibold text-zinc-800 dark:text-zinc-200 uppercase">Peter Oluchi </span>
                                    <span class="text-[10px] text-emerald-600 font-medium">Verified Geolocation</span>
                                </div>
                            </div>
                        </flux:table.cell>

                        {{-- Application & Matric Numbers --}}
                        <flux:table.cell>
                            <div class="flex flex-col text-xs">
                                <span
                                    class="text-zinc-700 dark:text-zinc-300 font-mono">FPN/HNDE/2024/0000000014473</span>
                                <span class="text-zinc-500 text-[10px] uppercase">Matric: FPN/CS/2024/003</span>
                            </div>
                        </flux:table.cell>

                        {{-- Specific Time of Sign-in --}}
                        <flux:table.cell align="center">
                            <div class="flex flex-col items-center">
                                <span class="text-sm font-medium text-zinc-800 dark:text-zinc-200">09:12 AM</span>
                                <span class="text-[9px] text-zinc-400 uppercase tracking-tighter">12 mins after
                                    start</span>
                            </div>
                        </flux:table.cell>

                        {{-- Action: Suspend Student --}}
                        <flux:table.cell align="right">
                            <div class="flex justify-end items-center gap-2">

                                <flux:button variant="ghost" size="sm" color="emerald" icon="user-plus"
                                    class="text-zinc-500 hover:text-emerald-600 dark:text-zinc-400 dark:hover:text-emerald-400" style="color: #10b981">
                                    Unsuspend
                                </flux:button>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                    {{-- Loop ends here --}}
                </flux:table.rows>
            </flux:table>
        </flux:card>
    </div>
</x-layouts::lecturer>
