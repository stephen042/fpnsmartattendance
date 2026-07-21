<div>
    <div>
        <flux:card class="bg-zinc-50/80 dark:bg-zinc-900/50 border-zinc-200/60 shadow-sm" x-data="{
            selectedCourses: $wire.entangle('selectedCourses'),
        
            addCourse(event) {
                let value = event.target.value;
        
                if (value && value !== 'none' && !this.selectedCourses.includes(value)) {
                    this.selectedCourses.push(value);
                }
        
                event.target.value = 'none';
            },
        
            removeCourse(id) {
                this.selectedCourses = this.selectedCourses.filter(course => course != id);
            }
        }">

            <div class="flex items-center gap-2 mb-6">
                <flux:icon name="plus-circle" variant="outline" class="text-zinc-400" />

                <flux:heading size="lg">
                    New Course Assignment
                </flux:heading>
            </div>

            <div
                class="grid grid-cols-1 md:grid-cols-6 gap-6 items-end bg-white/50 dark:bg-white/[0.02] p-4 rounded-xl border border-zinc-200/50">

                {{-- Lecturer --}}
                <div class="md:col-span-2">

                    <flux:select wire:model="lecturer_id" label="Select Lecturer" searchable>

                        <flux:select.option value="none" selected>
                            Select a lecturer
                        </flux:select.option>
                        @foreach ($lecturers as $lecturer)
                            <flux:select.option value="{{ $lecturer->id }}">
                                {{ $lecturer->name }}
                            </flux:select.option>
                        @endforeach

                    </flux:select>

                </div>

                {{-- Selected Courses --}}
                <div class="md:col-span-3">

                    <div class="flex flex-wrap gap-2 mb-3" x-show="selectedCourses.length">

                        <template x-for="courseId in selectedCourses" :key="courseId">

                            <span
                                class="inline-flex items-center gap-1 px-3 py-1 rounded-lg text-xs bg-zinc-200 dark:bg-zinc-800 cursor-pointer"
                                @click="removeCourse(courseId)">

                                <span
                                    x-text="
                                [...$refs.courseSelect.options]
                                .find(o => o.value == courseId)?.text
                            ">
                                </span>

                                ✕
                            </span>

                        </template>

                    </div>

                    <flux:select x-ref="courseSelect" label="Select Courses" searchable @change="addCourse">

                        <flux:select.option value="none" selected>
                            Select courses to assign
                        </flux:select.option>

                        @foreach ($courses as $course)
                            <flux:select.option value="{{ $course->id }}">
                                {{ $course->course_code }} - {{ $course->course_name }}

                                @if ($course->course_type === 'practical')
                                    (Practical)
                                @endif
                            </flux:select.option>
                        @endforeach

                    </flux:select>

                </div>

                {{-- Button --}}
                <div class="md:col-span-1">

                    <flux:button wire:click="assignCourses" variant="primary" icon="link" class="w-full">

                        Assign

                    </flux:button>

                </div>

            </div>

            @if (session()->has('success'))
                <div class="mt-4 text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif

        </flux:card>

        {{-- Card 2: Active Assignments Table --}}
        <flux:card class="bg-white dark:bg-zinc-900 shadow-sm mt-6">

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">

                <div>
                    <flux:heading size="lg">
                        Active Assignments
                    </flux:heading>

                    <flux:subheading>
                        Overview of course allocations per faculty member.
                    </flux:subheading>
                </div>

                <div class="w-full sm:max-w-xs">
                    <flux:input wire:model.live.debounce.500ms="search" size="sm" icon="magnifying-glass"
                        placeholder="Search assignments..." />
                </div>

            </div>

            <flux:table>

                <flux:table.columns>
                    <flux:table.column class="w-1/4">
                        Lecturer
                    </flux:table.column>

                    <flux:table.column class="w-3/4">
                        Assigned Modules
                    </flux:table.column>
                </flux:table.columns>

                <flux:table.rows>

                    @forelse($assignments as $lecturer)

                        @if ($lecturer->assignedCourses->count())
                            <flux:table.row class="align-top">

                                <flux:table.cell class="py-3">

                                    <div class="font-semibold text-zinc-900 dark:text-white">
                                        {{ $lecturer->name }}
                                    </div>

                                    <div class="text-xs text-zinc-400 mt-0.5">
                                        {{ $lecturer->assignedCourses->count() }}
                                        {{ Str::plural('allocation', $lecturer->assignedCourses->count()) }}
                                    </div>

                                </flux:table.cell>

                                <flux:table.cell class="p-0">

                                    <div class="w-full divide-y divide-zinc-100 dark:divide-zinc-800/60">

                                        @foreach ($lecturer->assignedCourses as $assignment)
                                            <div
                                                class="flex items-center justify-between py-2.5 px-4 hover:bg-zinc-50/50 dark:hover:bg-zinc-800/20 text-sm">

                                                <div class="flex items-center gap-3 min-w-0">

                                                    <span
                                                        class="font-mono font-bold text-zinc-500 dark:text-zinc-400 w-16 shrink-0">

                                                        {{ $assignment->course->course_code }}

                                                    </span>

                                                    <span class="text-zinc-800 dark:text-zinc-200 truncate">

                                                        {{ $assignment->course->course_name }}

                                                    </span>

                                                </div>

                                                <div
                                                    class="flex items-center gap-6 shrink-0 text-xs font-medium text-zinc-500 dark:text-zinc-400">

                                                    <span class="w-16 text-center">
                                                        {{ $assignment->course->level?->slug }}
                                                    </span>

                                                    <span class="w-12 text-right">

                                                        {{ $assignment->course->course_type === 'practical' ? 'Pract' : 'Theo' }}

                                                    </span>

                                                    <flux:button wire:click="removeAssignment({{ $assignment->id }})"
                                                        wire:confirm="Remove this assignment?" variant="ghost"
                                                        size="sm" icon="trash"
                                                        class="text-zinc-400 hover:text-red-600" />

                                                </div>

                                            </div>
                                        @endforeach

                                    </div>

                                </flux:table.cell>

                            </flux:table.row>
                        @endif

                    @empty

                        <flux:table.row>

                            <flux:table.cell colspan="2" class="text-center py-10 text-zinc-500">

                                No assignments found.

                            </flux:table.cell>

                        </flux:table.row>

                    @endforelse

                </flux:table.rows>

            </flux:table>

        </flux:card>
    </div>
