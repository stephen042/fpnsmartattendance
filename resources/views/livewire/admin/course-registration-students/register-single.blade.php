<div class="lg:col-span-2 space-y-12">
    <flux:card class="space-y-6">
        <div>
            <flux:heading size="lg">Enroll Single Student into Course</flux:heading>
<<<<<<< HEAD
            <flux:subheading>
                Insert Student APP NO / MATRIC Number to auto-fill the student name. Select Level, Semester, and Course
                Option to load available course modules.
            </flux:subheading>
        </div>

=======
            <flux:subheading>Insert Student APP NO/ MATRIC Number to get the Student Name auto-filled. Then select the
                Academic Session *, Semester *, and Course Module to register the student into the course.
            </flux:subheading>
        </div>

        @if (session()->has('error'))
            <div class="p-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-900/30 dark:text-red-400">
                {{ session('error') }}
            </div>
        @endif

>>>>>>> bdbae82bf891f35a56e581b67be80b9749ccf902
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
<<<<<<< HEAD
=======
                {{-- <option value="">Choose Level</option> --}}
>>>>>>> bdbae82bf891f35a56e581b67be80b9749ccf902
                @foreach ($levels as $level)
                    <option value="{{ $level->id }}">{{ $level->name }} ({{ $level->slug }})</option>
                @endforeach
            </flux:select>

            {{-- Course Option (Dynamic) --}}
            <flux:select wire:model.live="course_option_id" label="Course Option" placeholder="Select Course Option"
                :disabled="!$level_id || $courseOptions->isEmpty()">
                @if (!$level_id)
<<<<<<< HEAD
                    <option value="">Select a Level first</option>
                @elseif ($courseOptions->isEmpty())
                    <option value="">No course option for this level</option>
                @else
=======
                    {{-- <option value="">Select a Level first</option> --}}
                @elseif ($courseOptions->isEmpty())
                    <option value="">No course option for this level</option>
                @else
                    {{-- <option value="">Choose Course Option</option> --}}
>>>>>>> bdbae82bf891f35a56e581b67be80b9749ccf902
                    @foreach ($courseOptions as $option)
                        <option value="{{ $option->id }}">{{ $option->name }} ({{ $option->code }})</option>
                    @endforeach
                @endif
            </flux:select>

            {{-- Academic Session --}}
            <flux:select wire:model="academic_session_id" label="Academic Session *" placeholder="Choose Session">
<<<<<<< HEAD
                @foreach ($academicSessions as $session)
                    <option value="{{ $session->id }}">
                        {{ $session->name }} {{ $session->is_active ? '- Active' : '' }}
                    </option>
=======
                {{-- <option value="">Choose Session</option> --}}
                @foreach ($academicSessions as $session)
                    <option value="{{ $session->id }}">{{ $session->name }}
                        {{ $active = $session->is_active ? '- Active' : '' }}</option>
>>>>>>> bdbae82bf891f35a56e581b67be80b9749ccf902
                @endforeach
            </flux:select>

            {{-- Semester --}}
<<<<<<< HEAD
            <flux:select wire:model.live="semester_id" label="Semester *" placeholder="Choose Semester">
=======
            <flux:select wire:model="semester_id" label="Semester *" placeholder="Choose Semester">
                {{-- <option value="">Choose Semester</option> --}}
>>>>>>> bdbae82bf891f35a56e581b67be80b9749ccf902
                @foreach ($semesters as $semester)
                    <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                @endforeach
            </flux:select>

            {{-- Programme --}}
            <flux:select wire:model="programme_id" label="Programme *" placeholder="Choose Programme">
<<<<<<< HEAD
=======
                {{-- <option value="">Choose Programme</option> --}}
>>>>>>> bdbae82bf891f35a56e581b67be80b9749ccf902
                @foreach ($programmes as $programme)
                    <option value="{{ $programme->id }}">{{ $programme->name }}</option>
                @endforeach
            </flux:select>

<<<<<<< HEAD
            {{-- Course Modules (Dynamic & Conditional Helper) --}}
            <div>
                @php
                    $missingSelections = [];
                    if (!$level_id) {
                        $missingSelections[] = 'Level';
                    }
                    if (!$semester_id) {
                        $missingSelections[] = 'Semester';
                    }
                    if ($level_id && $courseOptions->isNotEmpty() && !$course_option_id) {
                        $missingSelections[] = 'Course Option';
                    }
                @endphp

                <flux:select wire:model="course_id" label="Course Module *" placeholder="Choose Course"
                    :disabled="count($missingSelections) > 0 || $courses->isEmpty()">

                    @if (count($missingSelections) > 0)
                        <option value="">Select {{ implode(', ', $missingSelections) }} first</option>
                    @elseif ($courses->isEmpty())
                        <option value="">No courses found for selected Level, Semester & Option</option>
                    @else
                        <option value="">Select Course</option>
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

                {{-- Contextual feedback notice when prerequisites are missing --}}
                @if (count($missingSelections) > 0)
                    <div class="flex items-center gap-1.5 mt-1 text-xs text-amber-600 dark:text-amber-400 font-medium">
                        <flux:icon name="exclamation-triangle" variant="micro" class="shrink-0" />
                        <span>Please select {{ implode(', ', $missingSelections) }} to load course modules.</span>
                    </div>
                @elseif ($level_id && $semester_id && $courses->isEmpty())
                    <div class="flex items-center gap-1.5 mt-1 text-xs text-red-500 font-medium">
                        <flux:icon name="x-circle" variant="micro" class="shrink-0" />
                        <span>No courses match the chosen Level, Semester, and Option.</span>
                    </div>
                @endif

                @error('course_id')
                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

        </div>

        <div class="flex pt-2">
=======
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
>>>>>>> bdbae82bf891f35a56e581b67be80b9749ccf902
            <flux:button wire:click="saveRegistration" variant="primary" icon="plus" class="px-8">
                Save Course Registration
            </flux:button>
        </div>
<<<<<<< HEAD

        @if (session()->has('success'))
            <div class="p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900/30 dark:text-green-400"
                style="color: green; background-color: #d4edda; border-color: #c3e6cb;">
                {{ session('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="p-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-900/30 dark:text-red-400">
                {{ session('error') }}
            </div>
        @endif
=======
        @if (session()->has('success'))
            <div class="p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900/30 dark:text-green-400" style="color: green; background-color: #d4edda; border-color: #c3e6cb;">
                {{ session('success') }}
            </div>
        @endif
>>>>>>> bdbae82bf891f35a56e581b67be80b9749ccf902
    </flux:card>
</div>
