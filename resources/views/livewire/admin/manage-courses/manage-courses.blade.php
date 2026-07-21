<div>
    <flux:card class="bg-zinc-50/80 dark:bg-zinc-900/50 border-zinc-200/60 shadow-sm">
        <div class="flex items-center gap-2 mb-6">
            <flux:icon name="book-open" variant="outline" class="text-zinc-400" />
            <flux:heading size="lg">Create Management</flux:heading>
        </div>

        {{-- Add Course Form --}}
        <div
            class="grid grid-cols-1 md:grid-cols-6 gap-4 items-end mb-8 bg-white/50 dark:bg-white/[0.02] p-4 rounded-xl border border-zinc-200/50">
            <div class="md:col-span-2">
                <flux:input wire:model="course_name" label="Course Title" />
            </div>

            <flux:input wire:model="course_code" label="Course Code" />

            {{-- Practical Checkbox - Vertical alignment is handled by 'items-end' on the parent grid --}}
            <div class="flex items-center pb-3">
                <flux:checkbox wire:model="course_type" value="practical" label="Practical" />
                <span class="text-sm text-zinc-400 md:col-span-6">
                    Click if this course is a practical course. This will help in categorizing courses for better management and reporting.
                </span>
            </div>

            <flux:select wire:model.live="level_id" label="Level">
                <flux:select.option value="">
                    Select Level
                </flux:select.option>
                @foreach ($levels as $level)
                    <flux:select.option value="{{ $level->id }}">
                        {{ $level->slug }}
                    </flux:select.option>
                @endforeach
            </flux:select>

            @if ($courseOptions->count())
                <flux:select wire:model="course_option_id" label="Course Option">
                    <flux:select.option value="">
                        Select Option
                    </flux:select.option>

                    @foreach ($courseOptions as $option)
                        <flux:select.option value="{{ $option->id }}">
                            {{ $option->name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>
            @endif

            <div class="md:col-span-6 flex justify-end mt-2">
                <flux:button wire:click="createCourse">
                    Add Course to Catalog
                </flux:button>
            </div>
        </div>

        <flux:table>
            <flux:table.columns>
                <flux:table.column>Course Details</flux:table.column>
                <flux:table.column align="center">Level</flux:table.column>
                <flux:table.column align="center">Option</flux:table.column>
                <flux:table.column align="center">Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($courses as $course)
                    <flux:table.row>

                        <flux:table.cell>
                            <div class="flex flex-col">
                                <span class="font-medium">
                                    {{ $course->course_name }}
                                </span>

                                <span class="text-xs text-zinc-500 uppercase">
                                    {{ $course->course_code }}
                                </span>

                                @if ($course->course_type === 'practical')
                                    <div class="mt-1">
                                        <flux:badge color="emerald" size="sm">
                                            Practical
                                        </flux:badge>
                                    </div>
                                @endif
                            </div>
                        </flux:table.cell>

                        <flux:table.cell align="center">
                            <flux:badge color="zinc">
                                {{ $course->level?->slug }}
                            </flux:badge>
                        </flux:table.cell>

                        <flux:table.cell align="center">
                            {{ $course->option?->name ?? 'General' }}
                        </flux:table.cell>

                        <flux:table.cell align="center">
                            <flux:modal.trigger name="edit-course">
                                <flux:button wire:click="edit({{ $course->id }})" variant="ghost" size="sm">
                                    Edit
                                </flux:button>
                            </flux:modal.trigger>
                        </flux:table.cell>

                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </flux:card>

    {{-- Edit Course Modal --}}
    <flux:modal name="edit-course" class="md:w-[550px] space-y-6">

        <div>
            <flux:heading size="lg">Edit Course Details</flux:heading>
            <flux:subheading>
                Modify course settings for the current semester.
            </flux:subheading>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div class="md:col-span-2">
                <flux:input wire:model="edit_course_name" label="Course Name" />
            </div>

            <flux:input wire:model="edit_course_code" label="Course Code" />

            <div class="flex items-center">
                <flux:checkbox wire:model="edit_is_practical" label="Practical Course" />
            </div>

            <flux:select wire:model.live="edit_level_id" label="Level">
                @foreach ($levels as $level)
                    <flux:select.option value="{{ $level->id }}">
                        {{ $level->slug }}
                    </flux:select.option>
                @endforeach
            </flux:select>

            @if ($editCourseOptions->count())
                <flux:select wire:model="edit_course_option_id" label="Course Option">
                    <flux:select.option value="">
                        Select Option
                    </flux:select.option>

                    @foreach ($editCourseOptions as $option)
                        <flux:select.option value="{{ $option->id }}">
                            {{ $option->name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>
            @endif

        </div>

        <div class="flex flex-col-reverse md:flex-row justify-between gap-3 mt-6">

            <flux:button wire:click="deleteCourse" variant="ghost" icon="trash"
                style="color:#dc2626;border:1px dashed #dc2626;">
                Remove Course
            </flux:button>

            <div class="flex gap-2">
                <flux:modal.close>
                    <flux:button variant="ghost">
                        Cancel
                    </flux:button>
                </flux:modal.close>

                <flux:button wire:click="updateCourse" variant="primary">
                    Update Course
                </flux:button>
            </div>

        </div>

    </flux:modal>
</div>
