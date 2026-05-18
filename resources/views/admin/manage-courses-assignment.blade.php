<x-layouts::app :title="__('Lecture Course Assignment')">
    <div class="max-w-6xl mx-auto space-y-8 pb-12">
        {{-- Page Header --}}
        <div>
            <flux:heading size="xl">Course Assignments</flux:heading>
            <flux:subheading>
                Link lecturers to courses. Multiple lecturers can be assigned to a single course for practicals/labs.
            </flux:subheading>
        </div>

        {{-- Card 1: The Assignment Form --}}
        <flux:card class="bg-zinc-50/80 dark:bg-zinc-900/50 border-zinc-200/60 shadow-sm">
            <div class="flex items-center gap-2 mb-6">
                <flux:icon name="plus-circle" variant="outline" class="text-zinc-400" />
                <flux:heading size="lg">New Assignment</flux:heading>
            </div>

            <div
                class="grid grid-cols-1 md:grid-cols-6 gap-6 items-end bg-white/50 dark:bg-white/[0.02] p-4 rounded-xl border border-zinc-200/50">
                {{-- Lecturer Selection --}}
                <div class="md:col-span-2">
                    <flux:select label="Select Lecturer" placeholder="Choose lecturer..." searchable>
                        <flux:select.option value="1">Prof. John Doe</flux:select.option>
                        <flux:select.option value="2">Dr. Jane Smith</flux:select.option>
                    </flux:select>
                </div>

                {{-- Course Selection --}}
                <div class="md:col-span-3">
                    <flux:select label="Select Course" placeholder="Search course..." searchable>
                        <flux:select.option value="101">SWD412 - Software Development Lab</flux:select.option>
                        <flux:select.option value="102">CSC101 - Intro to Programming</flux:select.option>
                    </flux:select>
                </div>

                {{-- Action Button --}}
                <div class="md:col-span-1">
                    <flux:button variant="primary" icon="link" class="w-full">Assign</flux:button>
                </div>
            </div>
        </flux:card>

        {{-- Card 2: Active Assignments Table --}}
        <flux:card class="bg-white dark:bg-zinc-900 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-2" style="width:50%;">
                    <flux:heading size="lg">Active Assignments</flux:heading>
                </div>
                {{-- Optional: Quick Search for the table --}}
                <flux:input size="sm" icon="magnifying-glass" placeholder="Search assignments..."
                    style="width:50%;" align="right" />
            </div>

            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Lecturer</flux:table.column>
                    <flux:table.column>Course Details</flux:table.column>
                    <flux:table.column align="center">Date Assigned</flux:table.column>
                    <flux:table.column>Action</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    <flux:table.row>
                        <flux:table.cell class="font-medium text-zinc-900 dark:text-white">
                            Prof. John Doe
                        </flux:table.cell>

                        <flux:table.cell>
                            <div class="flex items-center gap-3">
                                <div class="flex flex-col">
                                    <span class="font-medium">Backend Development 2</span>
                                    <span class="text-xs text-zinc-500 uppercase">
                                        SWD413
                                    </span>
                                    <div class="flex items-center mt-1">
                                        <flux:badge color="emerald" size="sm" variant="flat">Practical</flux:badge>
                                    </div>
                                </div>
                            </div>
                        </flux:table.cell>

                        <flux:table.cell align="center" class="text-zinc-500 text-sm">
                            2024-Feb-15
                        </flux:table.cell>

                        <flux:table.cell align="right">
                            <flux:button variant="ghost" size="sm" icon="trash"
                                class="text-red-600 hover:text-red-700" />
                        </flux:table.cell>
                    </flux:table.row>
                </flux:table.rows>
            </flux:table>
        </flux:card>
    </div>
</x-layouts::app>
