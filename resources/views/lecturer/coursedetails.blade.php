<x-layouts::lecturer :title="__('Class Details')">
    <div class="space-y-6">
        <flux:button variant="ghost" size="sm" color="zinc" onclick="window.history.back()" icon="arrow-left">
            Back
        </flux:button>


        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 border-zinc-200 dark:border-zinc-800 pt-6">

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
                    <div class="flex justify-between text-[10px] uppercase font-bold text-zinc-400 tracking-wider">
                        <span>Attendance Avg. For This Class Session</span>
                        <span class="text-emerald-500">85%</span>
                    </div>
                    <div class="w-full bg-zinc-100 dark:bg-zinc-800 rounded-full h-1.5">
                        <div class="bg-emerald-500 h-1.5 rounded-full" style="width: 85%"></div>
                    </div>
                </div>
            </div>

        </div>

        <flux:card class="bg-white dark:bg-zinc-900 border-zinc-200/60 shadow-sm mt-6">
            <div
                class="p-6 border-b border-zinc-100 dark:border-zinc-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <flux:heading size="lg">Class Sessions</flux:heading>
                    <flux:subheading italic>History of all classes held for this course.</flux:subheading>
                </div>

                <div class="flex items-center gap-3">
                    <flux:button icon="document-arrow-down" variant="outline" size="sm">Export Course Registry
                    </flux:button>
                </div>
            </div>

            <flux:table>
                <flux:table.columns>
                    <flux:table.column sortable>Date</flux:table.column>
                    <flux:table.column>Timeline</flux:table.column>
                    <flux:table.column align="center">Students</flux:table.column>
                    <flux:table.column align="center">Attendance Rate</flux:table.column>
                    <flux:table.column align="right">Actions</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    {{-- Example: A Session Record --}}
                    <flux:table.row>
                        {{-- Date Column --}}
                        <flux:table.cell>
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex flex-col items-center justify-center size-10 rounded-lg bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700">
                                    <span class="text-[10px] uppercase font-bold text-zinc-500">Apr</span>
                                    <span class="text-sm font-black text-zinc-800 dark:text-zinc-200">20</span>
                                </div>
                                <span class="font-semibold text-zinc-800 dark:text-zinc-200">Monday</span>
                            </div>
                        </flux:table.cell>

                        {{-- Start and End Time --}}
                        <flux:table.cell>
                            <div class="flex flex-col">
                                <div class="flex items-center gap-1.5 text-zinc-700 dark:text-zinc-300">
                                    <flux:icon name="clock" variant="micro" class="text-zinc-400" />
                                    <span class="text-sm font-medium">09:00 AM - 11:00 AM</span>
                                </div>
                                <span class="text-[10px] text-zinc-500 mt-0.5">Duration: 2h 0m</span>
                            </div>
                        </flux:table.cell>

                        {{-- Number of Students --}}
                        <flux:table.cell align="center">
                            <div class="flex flex-col items-center">
                                <span class="text-sm font-bold text-zinc-800 dark:text-zinc-200">112</span>
                                <span class="text-[9px] text-zinc-400 uppercase tracking-tighter">Present</span>
                            </div>
                        </flux:table.cell>

                        {{-- Attendance Rate --}}
                        <flux:table.cell align="center">
                            <div class="flex flex-col items-center gap-1">
                                <div class="flex items-baseline gap-1">
                                    <span class="text-sm font-black text-emerald-600 dark:text-emerald-400">93%</span>
                                </div>
                                <div class="w-16 bg-zinc-100 dark:bg-zinc-800 h-1 rounded-full overflow-hidden">
                                    <div class="bg-emerald-500 h-full" style="width: 93%"></div>
                                </div>
                            </div>
                        </flux:table.cell>

                        {{-- Actions --}}
                        <flux:table.cell align="right">
                            <div class="flex justify-end gap-2">
                                <flux:button variant="ghost" size="sm" icon="arrow-down-tray"
                                    tooltip="Download CSV" />
                                <flux:button link :href="route('lecturer.classdetails', [1])" variant="subtle"
                                    size="sm" icon="chevron-right" icon-trailing>
                                    View Details
                                </flux:button>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                </flux:table.rows>
            </flux:table>
        </flux:card>
    </div>
</x-layouts::lecturer>
