<x-layouts::app :title="__('Student Enrollment')">
    <div class="space-y-8 max-w-7xl mx-auto pb-10">

        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">Student Enrollment</flux:heading>
                <flux:subheading>Manage single entries or bulk upload student records.</flux:subheading>
            </div>
            <flux:button icon="arrow-down-tray" variant="outline" size="sm">
                Download CSV Template
            </flux:button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-8">
                <flux:card class="space-y-6">
                    <div>
                        <flux:heading size="lg">Enroll Single Student</flux:heading>
                        <flux:subheading>Enter student details manually to create a new record.</flux:subheading>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                        <flux:input label="Application Number *" placeholder="FPN/HNDM/..." />

                        <flux:input label="Full Name *" placeholder="e.g. John Doe" />

                        <flux:select label="Level *" placeholder="Choose Level">
                            <option value="hnd1">HND 1</option>
                            <option value="hnd2">HND 2</option>
                            <option value="nd1">ND 1</option>
                            <option value="nd2">ND 2</option>
                        </flux:select>

                        <flux:select label="Program *" placeholder="Choose Program">
                            <option value="morning">Morning</option>
                            <option value="evening">Evening</option>
                            <option value="weekend">Weekend</option>
                        </flux:select>

                        <flux:select label="Course Option" placeholder="Select Specialization">
                            <option value="swd">Software Development (SWD)</option>
                            <option value="ncc">Network & Cyber Security (NCC)</option>
                            <option value="cloud">Cloud Engineering</option>
                        </flux:select>

                        <flux:input label="Matric Number" placeholder="CS/2023/..." />
                    </div>

                    <div class="flex">
                        <flux:button variant="primary" icon="user-plus" class="px-8">
                            Save Student Record
                        </flux:button>
                    </div>
                </flux:card>
            </div>

            <div class="space-y-8">
                <flux:card class="bg-zinc-50 dark:bg-white/5 border-dashed border-2">
                    <div class="space-y-4">
                        <div>
                            <flux:heading size="lg">Bulk Enrollment</flux:heading>
                            <flux:subheading>Upload a CSV file with student data.</flux:subheading>
                        </div>

                        <div
                            class="group relative flex flex-col items-center justify-center p-6 border-2 border-dashed border-zinc-300 dark:border-zinc-700 rounded-xl hover:border-blue-500 transition-colors cursor-pointer">
                            <flux:icon name="document-arrow-up" class="mb-2 text-zinc-400 group-hover:text-blue-500" />
                            <span class="text-xs text-zinc-500 text-center">Drag and drop file or click to
                                browse</span>
                            <input type="file" class="absolute inset-0 opacity-0 cursor-pointer">
                        </div>

                        <flux:button variant="filled" class="w-full">
                            Upload & Process CSV
                        </flux:button>
                    </div>
                </flux:card>
            </div>
        </div>
        <flux:card
            class="p-0 overflow-hidden bg-zinc-50/80 dark:bg-zinc-900/50 border-zinc-200/60 shadow-sm backdrop-blur-md">
            <div
                class="p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-zinc-200/50 dark:border-white/5">
                <div>
                    <div class="flex items-center gap-2">
                        <flux:heading size="lg">Review Enrollment Queue</flux:heading>
                        <flux:badge color="orange" size="sm">Draft Mode</flux:badge>
                    </div>
                    <flux:subheading>Review and correct student data before finalizing the enrollment.</flux:subheading>
                </div>

                <div class="flex items-center gap-2 w-full md:w-auto">
                    <flux:button variant="ghost" color="red" icon="trash" size="sm">
                        Clear Queue
                    </flux:button>
                    <flux:button variant="primary" icon="user-plus" class="px-6">
                        Finalize & Enroll Students
                    </flux:button>
                </div>
            </div>

            <div class="overflow-x-auto px-1">
                <flux:table class="min-w-[1100px] px-6">
                    <flux:table.columns>
                        <flux:table.column align="left" class="px-6">Full Name</flux:table.column>
                        <flux:table.column align="left" class="px-6">App No</flux:table.column>
                        <flux:table.column align="left" class="px-6">Matric No</flux:table.column>
                        <flux:table.column align="left" class="px-6">Level</flux:table.column>
                        <flux:table.column align="left" class="px-6">Programme</flux:table.column>
                        <flux:table.column align="center" class="px-6">Action</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        <flux:table.row class="group hover:bg-zinc-100/50 dark:hover:bg-white/5 transition-colors">
                            <flux:table.cell class="px-6 py-4">
                                <input type="text" value="John Doe"
                                    class="w-full bg-transparent border-none focus:ring-2 focus:ring-blue-500/20 rounded px-2 py-1 text-sm font-medium text-zinc-800 dark:text-zinc-200">
                            </flux:table.cell>

                            <flux:table.cell class="px-6 py-4">
                                <input type="text" value="FPN/HNDM/2019/001"
                                    class="w-full bg-transparent border-none focus:ring-2 focus:ring-blue-500/20 rounded px-2 py-1 text-sm text-zinc-500 font-mono uppercase">
                            </flux:table.cell>

                            <flux:table.cell class="px-6 py-4">
                                <input type="text" value="CS/2023/001"
                                    class="w-full bg-transparent border-none focus:ring-2 focus:ring-blue-500/20 rounded px-2 py-1 text-sm font-mono text-zinc-600 dark:text-zinc-400">
                            </flux:table.cell>

                            <flux:table.cell class="px-6 py-4">
                                <select
                                    class="bg-transparent border-none text-sm focus:ring-2 focus:ring-blue-500/20 rounded cursor-pointer">
                                    <option selected>HND 1</option>
                                    <option>HND 2</option>
                                    <option>ND 1</option>
                                    <option>ND 2</option>
                                </select>
                            </flux:table.cell>

                            <flux:table.cell class="px-6 py-4">
                                <select
                                    class="bg-transparent border-none text-sm focus:ring-2 focus:ring-blue-500/20 rounded cursor-pointer">
                                    <option selected>Morning</option>
                                    <option>Evening</option>
                                    <option>Weekend</option>
                                </select>
                            </flux:table.cell>

                            <flux:table.cell align="center" class="px-6 py-4">
                                <div
                                    class="flex items-center justify-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <flux:button variant="ghost" icon="check" size="sm" class="text-green-600" />
                                    <flux:button variant="ghost" color="red" icon="x-mark" size="sm" />
                                </div>
                            </flux:table.cell>
                        </flux:table.row>

                        <flux:table.row class="bg-red-50/30 dark:bg-red-900/10 group transition-colors">
                            <flux:table.cell class="px-6 py-4">
                                <input type="text" value="Jane Smith"
                                    class="w-full bg-transparent border-none focus:ring-2 focus:ring-red-500/20 rounded px-2 py-1 text-sm font-medium text-zinc-800 dark:text-zinc-200">
                            </flux:table.cell>

                            <flux:table.cell class="px-6 py-4">
                                <input type="text" value="MISSING_APP_NO"
                                    class="w-full bg-transparent border-none focus:ring-2 focus:ring-red-500/20 rounded px-2 py-1 text-sm text-red-600 font-bold italic">
                            </flux:table.cell>

                            <flux:table.cell class="px-6 py-4">
                                <input type="text" placeholder="Enter Matric No"
                                    class="w-full bg-transparent border-none focus:ring-2 focus:ring-red-500/20 rounded px-2 py-1 text-sm font-mono border-b-2 border-red-300">
                            </flux:table.cell>

                            <flux:table.cell class="px-6 py-4">
                                <select
                                    class="bg-transparent border-none text-sm focus:ring-2 focus:ring-red-500/20 rounded text-red-600">
                                    <option>Invalid</option>
                                </select>
                            </flux:table.cell>

                            <flux:table.cell class="px-6 py-4">
                                <select
                                    class="bg-transparent border-none text-sm focus:ring-2 focus:ring-red-500/20 rounded cursor-pointer">
                                    <option>Morning</option>
                                </select>
                            </flux:table.cell>

                            <flux:table.cell align="center" class="px-6 py-4">
                                <div class="flex items-center justify-center gap-1">
                                    <flux:button variant="ghost" icon="exclamation-triangle" size="sm"
                                        class="text-red-500" />
                                    <flux:button variant="ghost" color="red" icon="x-mark" size="sm" />
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    </flux:table.rows>
                </flux:table>
            </div>

            <div
                class="p-4 bg-zinc-100/50 dark:bg-white/5 border-t border-zinc-200/50 dark:border-white/5 flex justify-between items-center text-xs text-zinc-500">
                <p>Showing 2 students in queue</p>
                <p class="flex items-center gap-2">
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500"></span> 1
                        Ready</span>
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-red-500"></span> 1
                        Needs Correction</span>
                </p>
            </div>
        </flux:card>

        <flux:card class="space-y-4">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <flux:heading size="lg">Enrolled Students</flux:heading>
                <div class="w-full md:w-72">
                    <flux:input icon="magnifying-glass" placeholder="Search by name or App No..." size="sm" />
                </div>
            </div>

            <flux:table>
                <flux:table.columns>
                    <flux:table.column>App No</flux:table.column>
                    <flux:table.column>Full Name</flux:table.column>
                    <flux:table.column>Level</flux:table.column>
                    <flux:table.column>Program</flux:table.column>
                    <flux:table.column>Option</flux:table.column>
                    <flux:table.column>Mat No</flux:table.column>
                    <flux:table.column align="end">Action</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    <flux:table.row>
                        <flux:table.cell>FPN/HNDM/2019/001</flux:table.cell>
                        <flux:table.cell>John Doe</flux:table.cell>
                        <flux:table.cell>
                            <flux:badge size="sm">HND 1</flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>Morning</flux:table.cell>
                        <flux:table.cell>SWD</flux:table.cell>
                        <flux:table.cell>CS/2023/001</flux:table.cell>
                        <flux:table.cell align="end">
                            <flux:button icon="pencil" variant="ghost" size="sm"
                                :href="route('edit-student', [1])">
                                Edit
                            </flux:button>
                        </flux:table.cell>
                    </flux:table.row>
                </flux:table.rows>
            </flux:table>
        </flux:card>
    </div>
</x-layouts::app>
