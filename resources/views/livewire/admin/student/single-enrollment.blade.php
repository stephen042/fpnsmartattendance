<div class="lg:col-span-2 space-y-8">

    <flux:card class="space-y-6">

        <div>
            <flux:heading size="lg">
                Enroll Single Student
            </flux:heading>

            <flux:subheading>
                Enter student details manually to create a new record.
            </flux:subheading>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">

            <flux:input wire:model="application_number" label="Application Number *" placeholder="FPN/HNDM/..." />

            <flux:input wire:model="matric_number" label="Matric Number" placeholder="CS/2023/..." />

            <flux:input wire:model="full_name" label="Full Name *" placeholder="John Doe" />

            <flux:input wire:model="email" type="email" label="Email" placeholder="student@email.com" />

            <flux:input wire:model="phone" label="Phone Number" placeholder="080xxxxxxxx" />

            <flux:select wire:model="gender" label="Gender *">
                <option value="">Select Gender</option>

                <option value="male">
                    Male
                </option>

                <option value="female">
                    Female
                </option>
            </flux:select>

            <flux:select wire:model.live="department_id" label="Department *">
                <option value="">
                    Select Department
                </option>

                @foreach ($departments as $department)
                    <option value="{{ $department->id }}">
                        {{ $department->name }}
                    </option>
                @endforeach

            </flux:select>

            @if ($courseOptions == true)

                <flux:select wire:model="course_option_id" label="Course Option">
                    <option value="">
                        Select Course Option
                    </option>

                    @foreach ($courseOptions as $option)
                        <option value="{{ $option->id }}">
                            {{ $option->name }}
                        </option>
                    @endforeach

                </flux:select>

            @endif

            <flux:select wire:model="level_id" label="Level *">
                <option value="">
                    Select Level
                </option>

                @foreach ($levels as $level)
                    <option value="{{ $level->id }}">
                        {{ $level->name }}
                    </option>
                @endforeach

            </flux:select>

            <flux:select wire:model="programme_id" label="Programme *">
                <option value="">
                    Select Programme
                </option>

                @foreach ($programmes as $programme)
                    <option value="{{ $programme->id }}">
                        {{ $programme->name }}
                    </option>
                @endforeach

            </flux:select>

        </div>

        <div class="flex">
            <flux:button wire:click="save" variant="primary" icon="user-plus" class="px-8">
                Save Student Record
            </flux:button>
        </div>

        @if (session('success'))
            <div class="text-green-600 text-sm">
                {{ session('success') }}
            </div>
        @endif

    </flux:card>

</div>
