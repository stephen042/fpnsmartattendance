<x-layouts::app :title="__('Edit Student')">
    <div class="max-w-7xl mx-auto space-y-8 pb-12">

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <flux:button icon="arrow-left" variant="ghost" size="sm" :href="route('student-enrollment')" />
                <div>
                    <flux:heading size="xl">Edit Student Profile</flux:heading>
                    <flux:subheading>
                        Update record for <span class="text-zinc-800 dark:text-white font-medium">John Doe</span>
                    </flux:subheading>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <flux:button variant="ghost" icon="trash" size="sm" style="color:red; border:2px dashed red;">
                    Delete Student
                </flux:button>

                <flux:badge color="zinc">Last Updated: Just now</flux:badge>
            </div>
        </div>

        <flux:card class="space-y-6 bg-zinc-50/80 dark:bg-zinc-900/50 border-zinc-200/60 dark:border-zinc-800">
            <div class="flex items-center gap-2">
                <flux:icon name="user-circle" variant="outline" class="text-zinc-400" />
                <flux:heading size="lg">Student Information</flux:heading>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <flux:input label="Application Number *" value="FPN/HNDM/2019/001" />
                <flux:input label="Full Name *" value="John Doe" />

                <flux:select label="Level *" placeholder="Choose Level">
                    <option value="hnd1" selected>HND 1</option>
                    <option value="hnd2">HND 2</option>
                    <option value="nd1">ND 1</option>
                    <option value="nd2">ND 2</option>
                </flux:select>

                <flux:select label="Program *" placeholder="Choose Program">
                    <option value="morning" selected>Morning</option>
                    <option value="evening">Evening</option>
                    <option value="weekend">Weekend</option>
                </flux:select>

                <flux:select label="Course Option" placeholder="Select Specialization">
                    <option value="swd" selected>Software Development (SWD)</option>
                    <option value="ncc">Network & Cyber Security (NCC)</option>
                    <option value="cloud">Cloud Engineering</option>
                </flux:select>

                <flux:input label="Matric Number" value="CS/2023/001" />
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:button variant="primary" icon="check-circle">Update Student</flux:button>
                <flux:button variant="outline" icon="arrow-path">Undo Changes</flux:button>
            </div>
        </flux:card>

        <flux:card class="space-y-6 bg-zinc-100/50 dark:bg-white/[0.02] border-zinc-200/50 dark:border-zinc-800">
            <div class="flex items-center gap-2">
                <flux:icon name="funnel" variant="outline" class="text-zinc-400" />
                <flux:heading size="lg">Filter Attendance Records</flux:heading>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                <flux:select size="sm">
                    <option>All Levels</option>
                    <option>HND1</option>
                </flux:select>
                <flux:select size="sm">
                    <option>All Programmes</option>
                    <option>Morning</option>
                </flux:select>
                <flux:select size="sm">
                    <option>All Semesters</option>
                    <option>First</option>
                    <option>Second</option>
                </flux:select>
                <flux:button variant="filled" size="sm" class="w-full">Apply Filters</flux:button>
                <flux:button variant="outline" icon="document-arrow-down" size="sm" class="w-full">Export CSV
                </flux:button>
            </div>
        </flux:card>

        <flux:card
            class="p-0 overflow-hidden bg-zinc-50/80 dark:bg-zinc-900/50 border-zinc-200/60 dark:border-zinc-800">
            <div class="p-6">
                <flux:heading size="lg">Attendance History</flux:heading>
            </div>

            <div class="overflow-x-auto border-t border-zinc-200/60 dark:border-zinc-800">
                <flux:table class="min-w-[1000px] px-6">
                    <flux:table.columns>
                        <flux:table.column align="center">Date</flux:table.column>
                        <flux:table.column align="center">Full Name</flux:table.column>
                        <flux:table.column align="center">Level</flux:table.column>
                        <flux:table.column align="center">Programme</flux:table.column>
                        <flux:table.column align="center">Course Option</flux:table.column>
                        <flux:table.column align="center">App No</flux:table.column>
                        <flux:table.column align="center">MAT No</flux:table.column>
                        <flux:table.column align="center">Status</flux:table.column>
                        <flux:table.column align="center">Phone Fingerprint</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        <flux:table.row class="hover:bg-zinc-100/80 dark:hover:bg-white/5 transition-colors">
                            <flux:table.cell class="py-4 text-center whitespace-nowrap">Feb 24, 2026</flux:table.cell>
                            <flux:table.cell class="py-4 text-center font-medium">John Doe</flux:table.cell>
                            <flux:table.cell class="py-4 text-center">HND 1</flux:table.cell>
                            <flux:table.cell class="py-4 text-center">Morning</flux:table.cell>
                            <flux:table.cell class="py-4 text-center">SWD</flux:table.cell>
                            <flux:table.cell class="py-4 text-center whitespace-nowrap text-zinc-500">FPN/HNDM/2019/001
                            </flux:table.cell>
                            <flux:table.cell class="py-4 text-center font-mono text-xs">CS/2023/001</flux:table.cell>
                            <flux:table.cell class="py-4">
                                <div class="flex justify-center">
                                    <flux:badge color="green" size="sm">Present</flux:badge>
                                </div>
                            </flux:table.cell>
                            <flux:table.cell class="py-4 text-center">
                                <code
                                    class="text-[10px] bg-zinc-200/50 dark:bg-zinc-800 px-2 py-1 rounded font-mono text-zinc-600 dark:text-zinc-400">
                                    8f3a-92bc-11eb-a8b3-0242ac130003
                                </code>
                            </flux:table.cell>
                            </flux:row>
                    </flux:table.rows>
                </flux:table>
            </div>
        </flux:card>
    </div>
</x-layouts::app>
