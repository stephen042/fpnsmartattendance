<div>
    <flux:card class="bg-zinc-50/80 dark:bg-zinc-900/50 border-zinc-200/60 shadow-sm">
        <div class="flex items-center gap-2 mb-6">
            <flux:icon name="user-group" variant="outline" class="text-zinc-400" />
            <flux:heading size="lg">Lecturer Registration</flux:heading>
        </div>

        {{-- Registration Form --}}
        <div class="max-w-3xl">
            <div class="space-y-8 bg-white/50 dark:bg-white/[0.02] p-8 rounded-2xl border border-zinc-200/50 shadow-sm">

                {{-- Section 1: Basic Information --}}
                <section class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="h-8 w-1 bg-blue-500 rounded-full"></div>
                        <flux:heading size="lg">Basic Information</flux:heading>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-6 gap-6">
                        <div class="md:col-span-2">
                            <flux:select wire:model="title" label="Title">
                                <flux:select.option value="Prof.">Prof.</flux:select.option>
                                <flux:select.option value="Dr.">Dr.</flux:select.option>
                                <flux:select.option value="Mr.">Mr.</flux:select.option>
                                <flux:select.option value="Mrs.">Mrs.</flux:select.option>
                                <flux:select.option value="Engr.">Engr.</flux:select.option>
                            </flux:select>
                        </div>

                        <div class="md:col-span-4">
                            <flux:input wire:model="full_name" label="Full Name" />
                        </div>

                        <div class="md:col-span-3">
                            <flux:select wire:model="gender" label="Gender">
                                <flux:select.option value="male">Male</flux:select.option>
                                <flux:select.option value="female">Female</flux:select.option>
                            </flux:select>
                        </div>

                        <div class="md:col-span-3">
                            <flux:input wire:model="phone_number" label="Phone Number" icon="phone" />
                        </div>

                        <div class="md:col-span-6">
                            <flux:input wire:model="staff_id" label="Staff ID" placeholder="FPNO/HNDE/2024/..."
                                icon="identification" />
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
                        <flux:input wire:model="email" type="email" label="Login Email" icon="envelope" />

                        <flux:input wire:model="password" label="Initial Password" type="text" icon="key"
                            placeholder="••••••••" description="Use '123456' as the initial password." />
                    </div>
                </section>

                {{-- Submission Area --}}
                <div class="pt-4">
                    {{-- <flux:button variant="ghost" type="reset">Cancel</flux:button> --}}
                    <flux:button wire:click="registerLecturer" variant="primary" icon="user-plus" class="px-8">
                        Register Lecturer
                    </flux:button>
                    @if (session()->has('success'))
                        <div class="mt-2 text-sm text-green-600 dark:text-green-400">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </flux:card>

    <flux:card class="bg-zinc-50/80 dark:bg-zinc-900/50 border-zinc-200/60 shadow-sm mt-6">
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

                @foreach ($lecturers as $lecturer)
                    <flux:table.row>

                        <flux:table.cell>
                            <div class="flex items-center gap-3">

                                <flux:avatar initials="{{ strtoupper(substr($lecturer->full_name, 0, 1)) }}"
                                    size="sm" />

                                <div class="flex flex-col">
                                    <span class="font-medium">
                                        {{ $lecturer->title }} {{ $lecturer->full_name }}
                                    </span>

                                    <span class="text-xs text-zinc-500 uppercase">
                                        Staff ID: {{ $lecturer->staff_id }}
                                    </span>
                                </div>

                            </div>
                        </flux:table.cell>

                        <flux:table.cell>
                            <div class="flex flex-col">

                                <span class="font-semibold">
                                    {{ $lecturer->user->email }}
                                </span>

                                <div class="flex items-center gap-1 mt-1">
                                    <div class="h-1.5 w-1.5 rounded-full bg-green-500"></div>

                                    <span class="text-[10px] uppercase font-bold">
                                        Account Active
                                    </span>
                                </div>

                            </div>
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ $lecturer->phone_number }}
                        </flux:table.cell>

                        <flux:table.cell align="center">
                            {{ ucfirst($lecturer->gender) }}
                        </flux:table.cell>

                        <flux:table.cell align="right">

                            <flux:button variant="ghost" size="sm" icon="eye"
                                href="{{ route('edit-lecturer-data', ['id' => $lecturer->id]) }}">
                                View Details
                            </flux:button>

                        </flux:table.cell>

                    </flux:table.row>
                @endforeach

            </flux:table.rows>
        </flux:table>
    </flux:card>
</div>
