<div class="lg:col-span-2 space-y-12">
    <flux:card class="space-y-6">
        <div>
            <flux:heading size="lg">Enroll Single Student into Course</flux:heading>
            <flux:subheading>Insert Student APP NO/ MATRIC Number to get the Student Name auto-filled. Then select the
                Academic Session *, Semester *, and Course Module to register the student into the course.
            </flux:subheading>
        </div>

        @if (session()->has('error'))
            <div class="p-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-900/30 dark:text-red-400">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">

            {{-- Student Lookup --}}
            <div>
                <flux:input wire:model.live.debounce.400ms="search_identifier" label="Student APP-NO / Matric *"
                    placeholder="Enter Student APP-NO / Matric" />
                @error('student_id')
                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- Auto-filled Student Name --}}
            <div>
                <flux:input wire:model="student_name" label="Student Name (Auto Filled)"
                    placeholder="{{ $search_identifier ? 'Searching...' : 'Student Name will be auto-filled' }}"
                    readonly />
            </div>

            {{-- Level --}}
            <flux:select wire:model.live="level_id" label="Level *" placeholder="Select Level">
                {{-- <option value="">Choose Level</option> --}}
                @foreach ($levels as $level)
                    <option value="{{ $level->id }}">{{ $level->name }} ({{ $level->slug }})</option>
                @endforeach
            </flux:select>

            {{-- Course Option (Dynamic) --}}
            <flux:select wire:model.live="course_option_id" label="Course Option" placeholder="Select Course Option"
                :disabled="!$level_id || $courseOptions->isEmpty()">
                @if (!$level_id)
                    {{-- <option value="">Select a Level first</option> --}}
                @elseif ($courseOptions->isEmpty())
                    <option value="">No course option for this level</option>
                @else
                    {{-- <option value="">Choose Course Option</option> --}}
                    @foreach ($courseOptions as $option)
                        <option value="{{ $option->id }}">{{ $option->name }} ({{ $option->code }})</option>
                    @endforeach
                @endif
            </flux:select>

            {{-- Academic Session --}}
            <flux:select wire:model="academic_session_id" label="Academic Session *" placeholder="Choose Session">
                {{-- <option value="">Choose Session</option> --}}
                @foreach ($academicSessions as $session)
                    <option value="{{ $session->id }}">{{ $session->name }}
                        {{ $active = $session->is_active ? '- Active' : '' }}</option>
                @endforeach
            </flux:select>

            {{-- Semester --}}
            <flux:select wire:model="semester_id" label="Semester *" placeholder="Choose Semester">
                {{-- <option value="">Choose Semester</option> --}}
                @foreach ($semesters as $semester)
                    <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                @endforeach
            </flux:select>

            {{-- Programme --}}
            <flux:select wire:model="programme_id" label="Programme *" placeholder="Choose Programme">
                {{-- <option value="">Choose Programme</option> --}}
                @foreach ($programmes as $programme)
                    <option value="{{ $programme->id }}">{{ $programme->name }}</option>
                @endforeach
            </flux:select>

            {{-- Course Modules (Dynamic) --}}
            <flux:select wire:model="course_id" label="Course Module *" placeholder="Choose Course"
                :disabled="!$level_id">
                @if (!$level_id)
                    {{-- <option value="">Select a Level first</option> --}}
                @elseif ($courses->isEmpty())
                    {{-- <option value="">No courses found for this scope</option> --}}
                @else
                    {{-- <option value="">Choose Course</option> --}}
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}">
                            {{ $course->course_name }} ({{ $course->course_code }})
                            @if ($course->course_type === 'practical')
                                - [Practical]
                            @endif
                        </option>
                    @endforeach
                @endif
            </flux:select>

        </div>

        <div class="flex">
            <flux:button wire:click="saveRegistration" variant="primary" icon="plus" class="px-8">
                Save Course Registration
            </flux:button>
        </div>
        @if (session()->has('success'))
            <div class="p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900/30 dark:text-green-400" style="color: green; background-color: #d4edda; border-color: #c3e6cb;">
                {{ session('success') }}
            </div>
        @endif
    </flux:card>
</div>
