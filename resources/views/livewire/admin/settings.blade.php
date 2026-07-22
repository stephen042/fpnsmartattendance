<div class="max-w-4xl mx-auto space-y-8 pb-12">

    <div>
        <flux:heading size="xl">Global Application Settings</flux:heading>
        <flux:subheading>Configure system-wide academic variables, network firewalls, and institutional faculty
            definitions independently.</flux:subheading>
    </div>

    {{-- 1. ACADEMIC SESSIONS CARD --}}
    <div>
        <flux:card class="bg-zinc-50/80 dark:bg-zinc-900/50 border-zinc-200/60 shadow-sm">
            <div class="flex items-center gap-2 mb-6">
                <flux:icon name="clock" variant="outline" class="text-zinc-400" />
                <flux:heading size="lg">Create And Manage Academic Sessions</flux:heading>
            </div>

            {{-- CREATE FORM --}}
            <form wire:submit="createAcademicSession"
                class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end mb-8 bg-white/50 dark:bg-white/[0.02] p-4 rounded-xl border border-zinc-200/50">
                <flux:input wire:model="session_name" label="Academic Session Name" placeholder="e.g. 2024/2025" />
                <flux:button type="submit" variant="primary" icon="plus">
                    Create Academic Session
                </flux:button>
            </form>

            {{-- TABLE --}}
            <flux:table>
                <flux:table.columns>
                    <flux:table.column align="center">Academic Session Name</flux:table.column>
                    <flux:table.column align="center">Status</flux:table.column>
                    <flux:table.column align="center">Action</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @forelse($academicSessions as $session)
                        <flux:table.row>
                            <flux:table.cell align="center" class="font-medium">
                                {{ $session->name }}
                            </flux:table.cell>

                            <flux:table.cell align="center">
                                @if ($session->is_active)
                                    <flux:badge color="green" size="sm">Active</flux:badge>
                                @else
                                    <flux:badge color="zinc" size="sm">Inactive</flux:badge>
                                @endif
                            </flux:table.cell>

                            <flux:table.cell align="center">
                                <flux:button wire:click="deleteAcademicSession({{ $session->id }})"
                                    wire:confirm="Are you sure you want to delete this session?" variant="ghost"
                                    size="sm" icon="trash" class="text-red-600 hover:text-red-700">
                                    Delete
                                </flux:button>
                            </flux:table.cell>
                        </flux:table.row>
                    @empty
                        <flux:table.row>
                            <flux:table.cell colspan="3" align="center">
                                No academic sessions found.
                            </flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>
        </flux:card>
    </div>

    {{-- 2. ACADEMIC SEMESTERS CARD --}}
    <div>
        <flux:card class="bg-zinc-50/80 dark:bg-zinc-900/50 border-zinc-200/60 shadow-sm">
            <div class="flex items-center gap-2 mb-6">
                <flux:icon name="calendar" variant="outline" class="text-zinc-400" />
                <flux:heading size="lg">Create And Manage Semesters</flux:heading>
            </div>

            <form wire:submit="createSemester"
                class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end mb-8 bg-white/50 dark:bg-white/[0.02] p-4 rounded-xl border border-zinc-200/50">
                <flux:input wire:model="semester_name" label="Semester Name" placeholder="e.g. First Semester" />
                <flux:button type="submit" variant="primary" icon="plus">
                    Create Semester
                </flux:button>
            </form>

            <flux:table>
                <flux:table.columns>
                    <flux:table.column align="center">Semester Name</flux:table.column>
                    <flux:table.column align="center">Status</flux:table.column>
                    <flux:table.column align="center">Action</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @forelse($semesters as $semester)
                        <flux:table.row>
                            <flux:table.cell align="center" class="font-medium">
                                {{ $semester->name }}
                            </flux:table.cell>

                            <flux:table.cell align="center">
                                @if ($semester->is_active)
                                    <flux:badge color="green" size="sm">Active</flux:badge>
                                @else
                                    <flux:badge color="zinc" size="sm">Inactive</flux:badge>
                                @endif
                            </flux:table.cell>

                            <flux:table.cell align="center">
                                <flux:button wire:click="deleteSemester({{ $semester->id }})"
                                    wire:confirm="Are you sure you want to delete this semester?" variant="ghost"
                                    size="sm" icon="trash" class="text-red-600 hover:text-red-700">
                                    Delete
                                </flux:button>
                            </flux:table.cell>
                        </flux:table.row>
                    @empty
                        <flux:table.row>
                            <flux:table.cell colspan="3" align="center">
                                No semesters found.
                            </flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>
        </flux:card>
    </div>

    {{-- 3. CURRENT ACTIVE CONTEXT --}}
    <form wire:submit="saveAcademicContext" class="block">
        <flux:card class="space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <flux:heading size="lg">Current Academic Context</flux:heading>
                    <flux:subheading>Set the active operational session and semester for student registrations and
                        exams.</flux:subheading>
                </div>
                <flux:button type="submit" variant="primary" icon="check" size="sm" class="sm:px-4 shrink-0">
                    Update Active Context
                </flux:button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                <flux:select wire:model="active_session_id" label="Active Academic Session *">
                    <option value="">Select active session...</option>
                    @foreach ($academicSessions as $session)
                        <option value="{{ $session->id }}">{{ $session->name }}</option>
                    @endforeach
                </flux:select>

                <flux:select wire:model="active_semester_id" label="Active Semester *">
                    <option value="">Select active semester...</option>
                    @foreach ($semesters as $semester)
                        <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                    @endforeach
                </flux:select>
            </div>
        </flux:card>
    </form>

    {{-- 4. NETWORK & IP RESTRICTIONS --}}
    <flux:card class="space-y-6">
        <div
            class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-zinc-100 dark:border-zinc-800">
            <div>
                <flux:heading size="lg">Network & IP Whitelist Restrictions</flux:heading>
                <flux:subheading>
                    Restrict student portal access to authorized institutional IP addresses or CIDR ranges.
                </flux:subheading>
            </div>

            {{-- Master Switch for restrict_ip --}}
            <div class="flex items-center gap-3 shrink-0" style="background-color: rgba(253, 33, 33, 0.48); padding: 0.5rem 1rem; border-radius: 0.375rem;">
                <span class="text-xs font-semibold uppercase tracking-wider text-zinc-100">
                    {{ $restrict_ip ? 'Enforced' : 'Disabled' }}
                </span>
                <flux:switch wire:model.live="restrict_ip" />
            </div>
        </div>

        {{-- Add IP Form --}}
        <form wire:submit="addIpRestriction" class="grid grid-cols-1 md:grid-cols-12 gap-3 pt-2">
            <div class="md:col-span-6">
                <flux:input wire:model="new_ip_pattern" placeholder="e.g. 192.168.1.* or 10.0.0.1"
                    label="IP / Subnet Pattern" />
            </div>
            <div class="md:col-span-4">
                <flux:input wire:model="new_ip_label" placeholder="e.g. Main CBT Lab"
                    label="Description / Location" />
            </div>
            <div class="md:col-span-2 flex items-end">
                <flux:button type="submit" variant="primary" icon="plus" class="w-full">
                    Add
                </flux:button>
            </div>
        </form>

        {{-- IP List --}}
        <div class="space-y-2 pt-2">
            @forelse($ipRestrictions as $ip)
                <div
                    class="flex items-center justify-between p-3 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg border border-zinc-200/60 dark:border-zinc-800">
                    <div class="flex items-center gap-3">
                        <span class="font-mono text-sm font-semibold text-zinc-800 dark:text-zinc-200">
                            {{ $ip->ip_pattern }}
                        </span>
                        @if ($ip->label)
                            <span class="text-xs text-zinc-500">({{ $ip->label }})</span>
                        @endif
                    </div>

                    <div class="flex items-center gap-2">
                        <flux:button wire:click="toggleIpStatus({{ $ip->id }})" size="xs"
                            variant="{{ $ip->is_active ? 'primary' : 'subtle' }}">
                            {{ $ip->is_active ? 'Active' : 'Disabled' }}
                        </flux:button>
                        <flux:button wire:click="deleteIpRestriction({{ $ip->id }})" variant="ghost"
                            color="red" icon="trash" size="sm" />
                    </div>
                </div>
            @empty
                <p class="text-xs text-zinc-400 italic">
                    No IP whitelists configured. System access is currently unrestricted.
                </p>
            @endforelse
        </div>
    </flux:card>

    {{-- 5. ACADEMIC DEPARTMENTS REGISTRY --}}
    <flux:card class="space-y-6">
        <div>
            <flux:heading size="lg">Academic Departments Registry</flux:heading>
            <flux:subheading>Manage institutional departments and short code identifiers.</flux:subheading>
        </div>

        {{-- Add Dept Form --}}
        <form wire:submit="createDepartment"
            class="grid grid-cols-1 md:grid-cols-12 gap-3 pt-4 border-t border-zinc-100 dark:border-zinc-800">
            <div class="md:col-span-7">
                <flux:input wire:model="department_name" placeholder="e.g. Computer Science"
                    label="Department Name" />
            </div>
            <div class="md:col-span-3">
                <flux:input wire:model="department_code" placeholder="e.g. CSC" class="uppercase"
                    label="System Code" />
            </div>
            <div class="md:col-span-2 flex items-end">
                <flux:button type="submit" variant="primary" icon="plus" class="w-full">
                    Add
                </flux:button>
            </div>
        </form>

        {{-- Dept List --}}
        <div class="space-y-2 pt-2">
            @forelse($departments as $dept)
                <div
                    class="flex items-center justify-between p-3 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg border border-zinc-200/60 dark:border-zinc-800">
                    <div>
                        <span class="font-medium text-zinc-800 dark:text-zinc-200">{{ $dept->name }}</span>
                        <span
                            class="ml-2 px-2 py-0.5 text-xs font-mono font-bold bg-zinc-200 dark:bg-zinc-700 rounded">{{ $dept->code }}</span>
                    </div>
                    <flux:button wire:click="deleteDepartment({{ $dept->id }})"
                        wire:confirm="Are you sure you want to delete this department?" variant="ghost"
                        color="red" icon="trash" size="sm" />
                </div>
            @empty
                <p class="text-xs text-zinc-400 italic">No departments registered yet.</p>
            @endforelse
        </div>
    </flux:card>

</div>
