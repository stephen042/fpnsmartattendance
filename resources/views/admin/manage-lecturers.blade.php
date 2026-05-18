<x-layouts::app :title="__('Manage Lecturers')">
    <div class="max-w-6xl mx-auto space-y-8 pb-12">

        {{-- Header Section --}}
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">Manage Lecturers</flux:heading>
                <flux:subheading>Register and oversee Deparment Lecturers and their assignments.</flux:subheading>
            </div>
        </div>

        <flux:card class="bg-zinc-50/80 dark:bg-zinc-900/50 border-zinc-200/60 shadow-sm">
            <div class="flex items-center gap-2 mb-6">
                <flux:icon name="user-group" variant="outline" class="text-zinc-400" />
                <flux:heading size="lg">Lecturer Registration</flux:heading>
            </div>

            {{-- Registration Form --}}
            <div class="max-w-3xl">
                <div
                    class="space-y-8 bg-white/50 dark:bg-white/[0.02] p-8 rounded-2xl border border-zinc-200/50 shadow-sm">

                    {{-- Section 1: Basic Information --}}
                    <section class="space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-1 bg-blue-500 rounded-full"></div>
                            <flux:heading size="lg">Basic Information</flux:heading>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-6 gap-6">
                            <div class="md:col-span-2">
                                <flux:select label="Title" placeholder="Choose Title">
                                    <flux:select.option>Prof.</flux:select.option>
                                    <flux:select.option>Dr.</flux:select.option>
                                    <flux:select.option>Mr.</flux:select.option>
                                    <flux:select.option>Ms.</flux:select.option>
                                    <flux:select.option>Engr.</flux:select.option>
                                </flux:select>
                            </div>

                            <div class="md:col-span-4">
                                <flux:input label="Full Name" placeholder="e.g. John Makuochukwu Doe" />
                            </div>

                            <div class="md:col-span-3">
                                <flux:select label="Gender" placeholder="Select Gender">
                                    <flux:select.option>Male</flux:select.option>
                                    <flux:select.option>Female</flux:select.option>
                                </flux:select>
                            </div>

                            <div class="md:col-span-3">
                                <flux:input label="Phone Number" placeholder="09087..." icon="phone" />
                            </div>

                            <div class="md:col-span-6">
                                <flux:input label="Staff ID" placeholder="FPNO/HNDE/2024/..." icon="identification" />
                            </div>
                        </div>
                    </section>

                    <hr class="border-zinc-100 dark:border-zinc-800" />

                    {{-- Section 2: Account Credentials --}}
                    <section class="space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-1 bg-emerald-500 rounded-full"></div>
                            <flux:heading size="lg">Account Login Credentials</flux:heading>
                        </div>

                        <div class="space-y-4">
                            <flux:input label="Login Email" type="email" icon="envelope"
                                placeholder="j.doe@fpno.edu.ng" description="This will be the lecturer's username." />

                            <flux:input label="Initial Password" type="text" icon="key" placeholder="••••••••"
                                description="The lecturer will be asked to change this on first login." />
                        </div>
                    </section>

                    {{-- Submission Area --}}
                    <div class="pt-4 flex justify-end gap-3">
                        {{-- <flux:button variant="ghost" type="reset">Cancel</flux:button> --}}
                        <flux:button variant="primary" icon="user-plus" class="px-8">
                            Register Lecturer
                        </flux:button>
                    </div>
                </div>
            </div>
            {{-- Lecturers Table --}}
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Lecturer</flux:table.column>
                    <flux:table.column>Login Details</flux:table.column>
                    <flux:table.column>Contact Info</flux:table.column>
                    <flux:table.column align="center">Gender</flux:table.column>
                    <flux:table.column align="right">Action</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    <flux:table.row>
                        <flux:table.cell>
                            <div class="flex items-center gap-3">
                                <flux:avatar initials="JD" size="sm" />
                                <div class="flex flex-col">
                                    <span class="font-medium text-zinc-900 dark:text-white">Prof. John Doe</span>
                                    <span class="text-xs text-zinc-500 uppercase tracking-tight">Staff ID:
                                        FPNO/2010/042</span>
                                </div>
                            </div>
                        </flux:table.cell>

                        <flux:table.cell>
                            <div class="flex flex-col">
                                <span
                                    class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">j.doe@fpno.edu.ng</span>
                                <div class="flex items-center gap-1.5 mt-1">
                                    <div class="h-1.5 w-1.5 rounded-full bg-green-500"></div>
                                    <span class="text-[10px] text-zinc-500 uppercase font-bold">Account Active</span>
                                </div>
                            </div>
                        </flux:table.cell>

                        <flux:table.cell>
                            <div class="flex flex-col text-sm text-zinc-600 dark:text-zinc-400">
                                <span>+234 812 345 6789</span>
                            </div>
                        </flux:table.cell>

                        <flux:table.cell align="center">
                            <span class="text-zinc-600 dark:text-zinc-400 text-sm">Male</span>
                        </flux:table.cell>

                        <flux:table.cell align="right">
                            <flux:button variant="ghost" size="sm" icon="eye" href="{{ route('edit-courses-assignment', ['id' => 1]) }}">
                                View Details
                            </flux:button>
                        </flux:table.cell>
                    </flux:table.row>
                </flux:table.rows>
            </flux:table>
        </flux:card>
    </div>
</x-layouts::app>
