<div class="max-w-7xl mx-auto space-y-8 pb-12">
    @if (session()->has('message'))
        <div class="p-3 bg-emerald-100 border border-emerald-300 text-emerald-800 rounded-lg text-sm">
            {{ session('message') }}
        </div>
    @endif

    {{-- Top Header Section --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <flux:button icon="arrow-left" variant="ghost" size="sm" :href="route('course-registration-students')" />
            <div>
                <flux:heading size="xl">Edit Course Registrations</flux:heading>
                <flux:subheading>
                    Modifying enrollment scope for
                    <span class="text-zinc-800 dark:text-white font-medium">
                        {{ $student->full_name ?? $student->first_name . ' ' . $student->last_name }}
                        ({{ $student->matric_number ?: ($student->application_number ?: 'N/A') }})
                    </span>
                </flux:subheading>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <flux:button wire:click="unenrollAll"
                wire:confirm="Are you sure you want to unenroll this student from ALL registered courses in this session?"
                variant="ghost" size="sm"
                style="border:1px solid ;border-color: #f87171; color: #b91c1c;"
                class="!text-red-600 !border-2 !border-dashed !border-red-500 hover:!bg-red-50 dark:hover:!bg-red-950/20">
                Unenroll Student From Scope
            </flux:button>
        </div>
    </div>

    {{-- Context Details Card --}}
    <flux:card class="space-y-6 bg-zinc-50/80 dark:bg-zinc-900/50 border-zinc-200/60 dark:border-zinc-800">
        <div class="flex items-center gap-2">
            <flux:icon name="academic-cap" variant="outline" class="text-zinc-400" />
            <flux:heading size="lg">Registration Context</flux:heading>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div class="p-3 bg-white dark:bg-zinc-800/60 rounded-lg border border-zinc-200 dark:border-zinc-700">
                <span class="text-xs text-zinc-400 block">Student</span>
                <strong class="text-zinc-800 dark:text-zinc-200">
                    {{ $student->full_name ?? $student->first_name . ' ' . $student->last_name }}
                </strong>
            </div>

            <div class="p-3 bg-white dark:bg-zinc-800/60 rounded-lg border border-zinc-200 dark:border-zinc-700">
                <span class="text-xs text-zinc-400 block">Academic Session</span>
                <strong class="text-zinc-800 dark:text-zinc-200">
                    {{ $primaryRegistration->academicSession->name ?? 'N/A' }}
                </strong>
            </div>

            <div class="p-3 bg-white dark:bg-zinc-800/60 rounded-lg border border-zinc-200 dark:border-zinc-700">
                <span class="text-xs text-zinc-400 block">Semester & Option</span>
                <strong class="text-zinc-800 dark:text-zinc-200">
                    {{ $primaryRegistration->semester->name ?? 'N/A' }}
                    ({{ $primaryRegistration->courseOption->name ?? 'General' }})
                </strong>
            </div>
        </div>
    </flux:card>

    {{-- Enrolled Courses Card --}}
    <flux:card class="space-y-6">
        <div>
            <flux:heading size="lg">Enrolled Courses ({{ count($activeCourses) }})</flux:heading>
            <flux:subheading size="sm">Add or remove individual course modules for this student's schedule.
            </flux:subheading>
        </div>

        {{-- Add New Course Select --}}
        <div
            class="flex items-center gap-3 bg-zinc-50 dark:bg-zinc-900 p-3 rounded-lg border border-zinc-200 dark:border-zinc-800">
            <div class="flex-1">
                <select wire:model="selectedNewCourseId"
                    class="w-full text-sm rounded-md border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 shadow-xs focus:ring-emerald-500 focus:border-emerald-500 py-2 px-3">
                    <option value="">-- Select a course to add --</option>
                    @foreach ($availableCourses as $course)
                        <option value="{{ $course->id }}">
                            {{ $course->course_code }} - {{ $course->course_name }}
                            {{ ($course->course_type ?? '') === 'practical' ? '[Practical]' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <flux:button wire:click="addCourse" variant="primary" icon="plus" size="sm">
                Add Course
            </flux:button>
        </div>

        {{-- Active Courses List --}}
        <div class="space-y-2">
            @forelse ($activeCourses as $course)
                @php
                    $isPractical = ($course->course_type ?? '') === 'practical';
                @endphp
                <div
                    class="flex items-center justify-between p-3 rounded-lg border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900/60 hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors">
                    <div class="flex items-center gap-3">
                        <span
                            class="inline-flex items-center px-1.5 py-px text-[6px] font-bold font-mono shadow-xs rounded-sm {{ $isPractical ? 'bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300' : 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300' }}">
                            {{ $course->course_code }}
                        </span>
                        <div>
                            <div class="text-sm font-medium text-zinc-800 dark:text-zinc-200">
                                {{ $course->course_name }}
                            </div>
                            <div class="text-xs text-zinc-400 font-mono">
                                Code: {{ $course->course_code }}
                            </div>
                        </div>
                    </div>

                    <flux:button wire:click="removeCourse({{ $course->id }})"
                        wire:confirm="Remove {{ $course->course_code }} from this student's enrollment?"
                        variant="ghost" size="xs" icon="trash"
                        class="!text-red-500 hover:!bg-red-50 dark:hover:!bg-red-950/30" />
                </div>
            @empty
                <div class="text-center py-8 text-zinc-400 text-sm">
                    No active courses registered under this scope. Select a course above to add one.
                </div>
            @endforelse
        </div>
    </flux:card>
</div>
