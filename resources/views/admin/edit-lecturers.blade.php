<x-layouts::app :title="__('Edit Lecturer')">
    <div class="max-w-6xl mx-auto space-y-8 pb-12">

        {{-- Back Link & Header --}}
        <div class="space-y-2">
            <flux:button href="{{ route('manage-lecturers') }}" variant="ghost" size="sm" icon="chevron-left"
                class="-ml-2">Back to
                Lecturers</flux:button>
            <flux:heading size="xl">Edit Lecturer Profile</flux:heading>
        </div>

        {{-- Card 1: Edit Details --}}
        <flux:card class="bg-white dark:bg-zinc-900 border-zinc-200/60 shadow-sm">
            <div class="flex items-center gap-2 mb-6 text-zinc-400">
                <flux:icon name="pencil-square" variant="outline" />
                <flux:heading size="lg">Personal Information</flux:heading>
            </div>

            <div class="space-y-8">
                {{-- Top Section: Inputs --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                    <flux:select label="Title">
                        <flux:select.option selected>Prof.</flux:select.option>
                        <flux:select.option>Dr.</flux:select.option>
                        <flux:select.option>Mr.</flux:select.option>
                        <flux:select.option>Mrs.</flux:select.option>
                        <flux:select.option>Msc.</flux:select.option>
                    </flux:select>

                    <flux:input label="Full Name" value="John Doe" />

                    <flux:input label="Email Address" type="email" value="j.doe@institution.edu" />

                    <flux:input label="Phone Number" value="+234 812 345 6789" />

                    <flux:select label="Gender">
                        <flux:select.option selected>Male</flux:select.option>
                        <flux:select.option>Female</flux:select.option>
                    </flux:select>

                    <flux:input label="Staff ID" value="FPNO/2010/042" />
                </div>

                {{-- Bottom Section: Profile Sidebar (Centered & Smaller) --}}
                <div class="flex justify-center w-full pt-4 border-t border-zinc-100 dark:border-zinc-800">
                    <div
                        class="w-full max-w-md bg-zinc-50 dark:bg-white/[0.02] p-6 rounded-xl border border-zinc-100 dark:border-zinc-800 space-y-4">
                        <div class="text-center pb-4 border-b border-zinc-200 dark:border-zinc-800">
                            <flux:avatar initials="JD" size="xl" class="mx-auto mb-3" />
                            <span class="text-xs font-bold text-zinc-400 uppercase tracking-widest block">
                                Staff ID: FPNO/2010/042
                            </span>
                        </div>

                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-zinc-500">Last Updated:</span>
                                <span class="font-medium text-zinc-700 dark:text-zinc-300">Jan 12, 2026</span>
                            </div>
                        </div>

                        <flux:button variant="primary" class="w-full" icon="check">Update Profile</flux:button>
                    </div>
                </div>
            </div>
        </flux:card>

        {{-- Card 2: Assigned Courses with Attendance Tracker --}}
        <flux:card class="bg-white dark:bg-zinc-900 border-zinc-200/60 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-2">
                    <flux:icon name="book-open" variant="outline" class="text-zinc-400" />
                    <flux:heading size="lg">Assigned Courses</flux:heading>
                </div>
                <flux:button size="sm" icon="plus" variant="ghost">Assign New Course</flux:button>
            </div>

            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Course</flux:table.column>
                    <flux:table.column>Program / Level</flux:table.column>
                    <flux:table.column align="center">Total Students</flux:table.column>
                    <flux:table.column>Avg. Attendance</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    {{-- Row 1: Good Attendance --}}
                    <flux:table.row>
                        <flux:table.cell>
                            <div class="flex flex-col">
                                <span class="font-medium">Object Oriented Programming</span>
                                <span class="text-xs text-zinc-500">SWD211</span>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell>
                            <div class="flex gap-2">
                                <flux:badge size="sm" color="zinc">Morning</flux:badge>
                                <flux:badge size="sm" color="zinc" variant="outline">ND2</flux:badge>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell align="center" class="font-semibold">120</flux:table.cell>
                        <flux:table.cell>
                            <div class="w-full max-w-[120px] space-y-1">
                                <div class="flex justify-between text-[10px] font-bold uppercase">
                                    <span class="text-green-600">Healthy</span>
                                    <span>88%</span>
                                </div>
                                <div class="w-full bg-zinc-100 dark:bg-zinc-800 h-1.5 rounded-full overflow-hidden">
                                    <div class="bg-green-500 h-full" style="width: 88%"></div>
                                </div>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>

                    {{-- Row 2: Poor Attendance --}}
                    <flux:table.row>
                        <flux:table.cell>
                            <div class="flex flex-col">
                                <span class="font-medium">Data Structures</span>
                                <span class="text-xs text-zinc-500">SWD212</span>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell>
                            <div class="flex gap-2">
                                <flux:badge size="sm" color="zinc">Evening</flux:badge>
                                <flux:badge size="sm" color="zinc" variant="outline">ND2</flux:badge>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell align="center" class="font-semibold">115</flux:table.cell>
                        <flux:table.cell>
                            <div class="w-full max-w-[120px] space-y-1">
                                <div class="flex justify-between text-[10px] font-bold uppercase">
                                    <span class="text-red-600">Low</span>
                                    <span>42%</span>
                                </div>
                                <div class="w-full bg-zinc-100 dark:bg-zinc-800 h-1.5 rounded-full overflow-hidden">
                                    <div class="bg-red-500 h-full" style="width: 42%"></div>
                                </div>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                </flux:table.rows>
            </flux:table>
        </flux:card>
    </div>
</x-layouts::app>
