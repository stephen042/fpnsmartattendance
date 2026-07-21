<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <flux:button icon="arrow-left" variant="ghost" size="sm" :href="route('student-enrollment')" />

            <div>
                <flux:heading size="xl">Edit Student Profile</flux:heading>

                <flux:subheading>
                    Update record for
                    <span class="text-zinc-800 dark:text-white font-medium">
                        {{ $full_name }}
                    </span>
                </flux:subheading>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <flux:button variant="ghost" icon="trash" size="sm" style="color:red; border:2px dashed red;"
                wire:click="confirmDelete">
                Delete Student
            </flux:button>

            <flux:badge color="zinc">
                Last Updated: Just now
            </flux:badge>
        </div>
    </div>

    {{-- CARD --}}
    <flux:card class="space-y-6 bg-zinc-50/80 dark:bg-zinc-900/50 border-zinc-200/60 dark:border-zinc-800">

        <div class="flex items-center gap-2">
            <flux:icon name="user-circle" variant="outline" class="text-zinc-400" />
            <flux:heading size="lg">Student Information</flux:heading>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">

            <flux:input label="Application Number *" wire:model="application_number" />

            <flux:input label="Matric Number" wire:model="matric_number" />

            <flux:input label="Full Name *" wire:model="full_name" />

            <flux:input type="email" label="Email" wire:model="email" />

            <flux:input label="Phone Number" wire:model="phone" />

            <flux:select label="Gender *" wire:model="gender">
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </flux:select>

            <flux:select label="Department *" wire:model="department_id">
                <option value="">Select Department</option>
                @foreach ($departments as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                @endforeach
            </flux:select>

            <flux:select label="Course Option" wire:model="course_option_id">
                <option value="">Select Course Option</option>
                @foreach ($courseOptions as $course)
                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                @endforeach
            </flux:select>

            <flux:select label="Level *" wire:model="level_id">
                <option value="">Select Level</option>
                @foreach ($levels as $level)
                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                @endforeach
            </flux:select>

            <flux:select label="Programme *" wire:model="programme_id">
                <option value="">Select Programme</option>
                @foreach ($programmes as $prog)
                    <option value="{{ $prog->id }}">{{ $prog->name }}</option>
                @endforeach
            </flux:select>

        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
            <flux:button variant="primary" icon="check-circle" wire:click="updateStudent">
                Update Student
            </flux:button>
        </div>

    </flux:card>
    @if ($confirmingDelete)
        <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-lg shadow-lg w-[400px] space-y-4">

                <flux:heading size="lg">Confirm Delete</flux:heading>

                <p class="text-sm text-zinc-600 dark:text-zinc-300">
                    Are you sure you want to delete this student ? This action cannot be undone.
                </p>

                <div class="flex justify-end gap-3">
                    <flux:button variant="outline" wire:click="$set('confirmingDelete', false)">
                        Cancel
                    </flux:button>

                    <flux:button variant="danger" wire:click="deleteStudent">
                        Yes, Delete
                    </flux:button>
                </div>

            </div>
        </div>
    @endif
</div>
