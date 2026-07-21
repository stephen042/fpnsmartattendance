<div>
    <flux:card class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <flux:heading size="lg">Active Course Registrations Log</flux:heading>
                <flux:subheading size="sm">
                    Manage student course enrollments and view registration histories.
                </flux:subheading>
            </div>

            <div class="flex items-center gap-2 w-full md:w-auto">
                {{-- Search Input --}}
                <div class="w-full md:w-80">
                    <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass"
                        placeholder="Search student, matric, app no, or course..." size="sm" />
                </div>

                {{-- Refresh & Clear Filters Button --}}
                <flux:button wire:click="refreshData" icon="arrow-path" variant="subtle" size="sm"
                    title="Reset Filters" style="border: 1px solid blue; background-color: #f0f8ff; color: #00008b;">
                    Refresh Table/Clear Filters
                </flux:button>
            </div>
        </div>

        {{-- Dropdown Filters Row --}}
        <div
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 p-4 bg-zinc-50 dark:bg-zinc-900/50 rounded-xl border border-zinc-200/60 dark:border-zinc-800">
            {{-- Filter: Academic Session --}}
            <flux:select wire:model.live="filter_session_id" label="Academic Session" size="sm"
                placeholder="All Sessions">
                <option value="">All Sessions</option>
                @foreach ($academicSessions as $session)
                    <option value="{{ $session->id }}">{{ $session->name }}</option>
                @endforeach
            </flux:select>

            {{-- Filter: Level --}}
            <flux:select wire:model.live="filter_level_id" label="Level" size="sm" placeholder="All Levels">
                <option value="">All Levels</option>
                @foreach ($levels as $level)
                    <option value="{{ $level->id }}">{{ $level->name }} ({{ $level->slug }})</option>
                @endforeach
            </flux:select>

            {{-- Filter: Semester --}}
            <flux:select wire:model.live="filter_semester_id" label="Semester" size="sm"
                placeholder="All Semesters">
                <option value="">All Semesters</option>
                @foreach ($semesters as $semester)
                    <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                @endforeach
            </flux:select>

            {{-- Filter: Course Option --}}
            <flux:select wire:model.live="filter_course_option_id" label="Course Option" size="sm"
                placeholder="All Options">
                <option value="">All Options</option>
                <option value="none">General / None</option>
                @foreach ($courseOptions as $option)
                    <option value="{{ $option->id }}">{{ $option->name }} ({{ $option->code }})</option>
                @endforeach
            </flux:select>
        </div>

        {{-- Table --}}
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Student Name / Identifier</flux:table.column>
                <flux:table.column class="w-1/3">Registered Course Code(s)</flux:table.column>
                <flux:table.column>Course Option</flux:table.column>
                <flux:table.column>Academic Session</flux:table.column>
                <flux:table.column>Semester</flux:table.column>
                <flux:table.column align="end">Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($paginatedGroupKeys as $groupKey)
                    @php
                        $key =
                            $groupKey->student_id .
                            '-' .
                            $groupKey->academic_session_id .
                            '-' .
                            $groupKey->semester_id .
                            '-' .
                            $groupKey->level_id .
                            '-' .
                            ($groupKey->course_option_id ?? 'none');
                        $group = $registrationGroups->get($key, collect());
                        $firstRecord = $group->first();
                        $student = $firstRecord?->student;
                    @endphp

                    @if ($firstRecord && $student)
                        <flux:table.row :key="$key">
                            {{-- Student Name / Matric or App No --}}
                            <flux:table.cell>
                                <div class="font-medium text-zinc-800 dark:text-zinc-200">
                                    {{ $student->full_name ?? $student->first_name . ' ' . $student->last_name }}
                                </div>
                                <div class="text-xs text-zinc-400 font-mono">
                                    {{ $student->matric_number ?: ($student->application_number ?: 'N/A') }}
                                </div>
                            </flux:table.cell>

                            {{-- Registered Course Codes Display --}}
                            <flux:table.cell>
                                <div class="flex flex-wrap gap-1.5 max-w-md">
                                    @foreach ($group as $registration)
                                        @php
                                            $course = $registration->course;
                                            $isPractical = ($course->course_type ?? '') === 'practical';
                                        @endphp
                                        <span title="{{ $course->course_name ?? 'Course' }}"
                                            class="inline-flex items-center px-1.5 py-px text-[10px] font-bold font-mono transition-transform hover:scale-105 cursor-pointer shadow-xs rounded-sm {{ $isPractical ? 'bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300' : 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300' }}">
                                            {{ $course->course_code ?? 'N/A' }}
                                        </span>
                                    @endforeach
                                </div>
                                <span class="text-[10px] text-zinc-400 mt-1 block">
                                    Total: {{ $group->count() }} course(s) registered
                                </span>
                            </flux:table.cell>

                            {{-- Course Option --}}
                            <flux:table.cell>
                                @if ($firstRecord->courseOption)
                                    <flux:badge size="sm" color="indigo" variant="flat">
                                        {{ $firstRecord->courseOption->name }}
                                        ({{ $firstRecord->courseOption->code }})
                                    </flux:badge>
                                @else
                                    <span class="text-xs text-zinc-400 italic">General / None</span>
                                @endif
                            </flux:table.cell>

                            {{-- Academic Session --}}
                            <flux:table.cell>
                                <flux:badge size="sm" color="zinc" variant="flat">
                                    {{ $firstRecord->academicSession->name ?? 'N/A' }}
                                </flux:badge>
                            </flux:table.cell>

                            {{-- Semester --}}
                            <flux:table.cell>
                                {{ $firstRecord->semester->name ?? 'N/A' }}
                            </flux:table.cell>

                            {{-- Actions --}}
                            <flux:table.cell align="end">
                                <flux:button icon="pencil" variant="ghost" size="sm"
                                    :href="route('edit-course-registration', [$firstRecord->id])">
                                    Edit
                                </flux:button>
                            </flux:table.cell>
                        </flux:table.row>
                    @endif
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="6" class="text-center py-8 text-zinc-500">
                            No registration records found matching the criteria.
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

        {{-- Livewire AJAX Pagination Links --}}
        @if ($paginatedGroupKeys->hasPages())
            <div class="pt-2">
                {{ $paginatedGroupKeys->links() }}
            </div>
        @endif
    </flux:card>
</div>
