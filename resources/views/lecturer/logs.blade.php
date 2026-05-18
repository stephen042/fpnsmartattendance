<x-layouts::lecturer :title="__('Class Details')">
    <div class="space-y-6">
        <flux:button variant="ghost" size="sm" color="zinc" onclick="window.history.back()"
            icon="arrow-left">
            Back 
        </flux:button>

        <flux:heading size="xl" level="1">Full Attendance Report</flux:heading>

        <flux:card class="bg-white dark:bg-zinc-900 border-zinc-200/60 shadow-sm mt-6">
            <div
                class="p-6 border-b border-zinc-100 dark:border-zinc-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <flux:heading size="lg">Session History</flux:heading>
                    <flux:subheading italic>Review and export past class attendance records.</flux:subheading>
                </div>

                <div class="flex items-center gap-3">
                    <flux:input icon="magnifying-glass" placeholder="Search course or date..." class="max-w-xs" />
                </div>
            </div>

            <flux:table>
                <flux:table.columns>
                    <flux:table.column sortable>Date & Time</flux:table.column>
                    <flux:table.column>Course Details</flux:table.column>
                    <flux:table.column align="center">Avg. Attendance</flux:table.column>
                    <flux:table.column align="right">Actions</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    {{-- Example: Active Session --}}
                    <flux:table.row>
                        <flux:table.cell>
                            <div class="flex flex-col gap-1.5">
                                <span class="font-semibold text-zinc-800 dark:text-zinc-200">April 20, 2026</span>
                                <span class="text-xs text-zinc-500 italic">09:00 AM - 11:00 AM</span>
                                <div class="flex">
                                    <flux:badge color="emerald" variant="flat" size="sm" class="animate-pulse">
                                        Active Now</flux:badge>
                                </div>
                            </div>
                        </flux:table.cell>

                        <flux:table.cell>
                            <div class="flex flex-col">
                                <span class="font-bold text-zinc-800 dark:text-zinc-200">Backend Development 2</span>
                                <div class="flex items-center gap-2 mt-1">
                                    <flux:badge size="xs" variant="outline" color="zinc">SWD413</flux:badge>
                                    <span
                                        class="text-[10px] text-zinc-400 uppercase font-medium tracking-wider">Practical</span>
                                </div>
                            </div>
                        </flux:table.cell>

                        <flux:table.cell align="center">
                            <div class="flex flex-col items-center gap-1">
                                <span class="text-sm font-bold text-emerald-600 dark:text-emerald-400">93%</span>
                                <flux:badge size="xs" variant="flat" color="zinc">5 classes</flux:badge>
                            </div>
                        </flux:table.cell>

                        <flux:table.cell align="right">
                            <div class="flex justify-end gap-2">
                                <flux:button link :href="route('lecturer.coursedetails', [1])" variant="subtle"
                                    size="sm" icon="eye">
                                    Full Report
                                </flux:button>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>

                    {{-- Example: Closed Session --}}
                    <flux:table.row>
                        <flux:table.cell>
                            <div class="flex flex-col gap-1.5">
                                <span class="font-semibold text-zinc-800 dark:text-zinc-200">April 18, 2026</span>
                                <span class="text-xs text-zinc-500 italic">12:00 PM - 02:00 PM</span>
                                <div class="flex">
                                    <flux:badge color="zinc" variant="flat" size="sm">Completed</flux:badge>
                                </div>
                            </div>
                        </flux:table.cell>

                        <flux:table.cell>
                            <div class="flex flex-col">
                                <span class="font-bold text-zinc-800 dark:text-zinc-200">Frontend Development 2</span>
                                <div class="flex items-center gap-2 mt-1">
                                    <flux:badge size="xs" variant="outline" color="zinc">SWD418</flux:badge>
                                    <span
                                        class="text-[10px] text-zinc-400 uppercase font-medium tracking-wider">Theory</span>
                                </div>
                            </div>
                        </flux:table.cell>

                        <flux:table.cell align="center">
                            <div class="flex flex-col items-center gap-1">
                                <span class="text-sm font-bold text-zinc-600 dark:text-zinc-400">81%</span>
                                <flux:badge size="xs" variant="flat" color="zinc">8 classes</flux:badge>
                            </div>
                        </flux:table.cell>

                        <flux:table.cell align="right">
                            <div class="flex justify-end gap-2">
                                <flux:button variant="ghost" size="sm" icon="arrow-down-tray"
                                    tooltip="Export CSV" />
                                <flux:button link :href="route('lecturer.coursedetails', [1])" variant="subtle"
                                    size="sm" icon="eye">
                                    Full Report
                                </flux:button>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                </flux:table.rows>
            </flux:table>
        </flux:card>

    </div>
</x-layouts::lecturer>
