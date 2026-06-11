<x-layouts::app :title="__('Lecture Course Assignment')">
    <div class="max-w-6xl mx-auto space-y-8 pb-12">
        {{-- Page Header --}}
        <div>
            <flux:heading size="xl">Course Assignments</flux:heading>
            <flux:subheading>
                Link lecturers to courses. Multiple lecturers can be assigned to a single course for practicals/labs.
            </flux:subheading>
        </div>

        {{-- Card 1: The Assignment Form --}}
        {{-- Card 1: The Assignment Form --}}
        <flux:card class="bg-zinc-50/80 dark:bg-zinc-900/50 border-zinc-200/60 shadow-sm" x-data="{
            selectedCourses: [],
            addCourse(event) {
                let select = event.target;
                let value = select.value;
                let text = select.options[select.selectedIndex].text;
        
                if (value && !this.selectedCourses.some(c => c.id === value)) {
                    this.selectedCourses.push({ id: value, name: text });
                }
                select.value = ''; // Reset select view
            },
            removeCourse(id) {
                this.selectedCourses = this.selectedCourses.filter(c => c.id !== id);
            }
        }">
            <div class="flex items-center gap-2 mb-6">
                <flux:icon name="plus-circle" variant="outline" class="text-zinc-400" />
                <flux:heading size="lg">New Assignment</flux:heading>
            </div>

            <template x-for="course in selectedCourses" :key="course.id">
                <input type="hidden" name="course_ids[]" :value="course.id">
            </template>

            <div
                class="grid grid-cols-1 md:grid-cols-6 gap-6 items-end bg-white/50 dark:bg-white/[0.02] p-4 rounded-xl border border-zinc-200/50">
                {{-- Lecturer Selection --}}
                <div class="md:col-span-2">
                    <flux:select label="Select Lecturer" placeholder="Choose lecturer..." searchable>
                        <flux:select.option value="1">Prof. John Doe</flux:select.option>
                        <flux:select.option value="2">Dr. Jane Smith</flux:select.option>
                    </flux:select>
                </div>

                {{-- Interactive Tag Container View --}}
                <div class="mt-4 flex flex-wrap gap-2" x-show="selectedCourses.length > 0" x-cloak>
                    <template x-for="course in selectedCourses" :key="course.id">
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-zinc-200/60 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-200 border border-zinc-300/40 dark:border-zinc-700/50 transition-all hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-950/40 dark:hover:text-red-400 group cursor-pointer"
                            @click="removeCourse(course.id)">
                            <span x-text="course.name"></span>
                            <flux:icon name="x-mark"
                                class="w-3 h-3 text-zinc-400 group-hover:text-red-500 transition-colors" />
                        </span>
                    </template>
                </div>

                {{-- Course Selection (Multi-select via Alpine logic) --}}
                <div class="md:col-span-3 space-y-2">
                    <flux:select label="Select Courses" placeholder="Search and add courses..." searchable
                        @change="addCourse">
                        <flux:select.option value="101">SWD412 - Software Development Lab</flux:select.option>
                        <flux:select.option value="102">CSC101 - Intro to Programming</flux:select.option>
                        <flux:select.option value="103">MTH102 - Mathematical Methods</flux:select.option>
                    </flux:select>
                </div>

                {{-- Action Button --}}
                <div class="md:col-span-1">
                    <flux:button variant="primary" icon="link" class="w-full"
                        ::disabled="selectedCourses.length === 0">
                        Assign
                    </flux:button>
                </div>
            </div>

        </flux:card>

        {{-- Card 2: Active Assignments Table --}}
        <flux:card class="bg-white dark:bg-zinc-900 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <flux:heading size="lg">Active Assignments</flux:heading>
                    <flux:subheading>Overview of course allocations per faculty member.</flux:subheading>
                </div>
                <div class="w-full sm:max-w-xs">
                    <flux:input size="sm" icon="magnifying-glass" placeholder="Search assignments..." />
                </div>
            </div>

            <flux:table>
                <flux:table.columns>
                    <flux:table.column class="w-1/4">Lecturer</flux:table.column>
                    <flux:table.column class="w-3/4">Assigned Modules</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    {{-- Row Block 1 --}}
                    <flux:table.row class="align-top">
                        {{-- Lecturer Information --}}
                        <flux:table.cell class="py-3">
                            <div class="font-semibold text-zinc-900 dark:text-white">Prof. John Doe</div>
                            <div class="text-xs text-zinc-400 mt-0.5">5 allocations</div>
                        </flux:table.cell>

                        {{-- Clean Sub-Table Modules --}}
                        <flux:table.cell class="p-0">
                            <div class="w-full divide-y divide-zinc-100 dark:divide-zinc-800/60">

                                <div
                                    class="flex items-center justify-between py-2.5 px-4 hover:bg-zinc-50/50 dark:hover:bg-zinc-800/20 text-sm">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <span
                                            class="font-mono font-bold text-zinc-500 dark:text-zinc-400 w-16 shrink-0">SWD413</span>
                                        <span class="text-zinc-800 dark:text-zinc-200 truncate">Backend Development
                                            2</span>
                                    </div>
                                    <div
                                        class="flex items-center gap-6 shrink-0 text-xs font-medium text-zinc-500 dark:text-zinc-400">
                                        <span class="w-12 text-center">HND 2</span>
                                        <span class="w-12 text-right">Pract</span>
                                        <flux:button variant="ghost" size="sm" icon="trash"
                                            class="text-zinc-400 hover:text-red-600" />
                                    </div>
                                </div>

                                <div
                                    class="flex items-center justify-between py-2.5 px-4 hover:bg-zinc-50/50 dark:hover:bg-zinc-800/20 text-sm">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <span
                                            class="font-mono font-bold text-zinc-500 dark:text-zinc-400 w-16 shrink-0">SWD412</span>
                                        <span class="text-zinc-800 dark:text-zinc-200 truncate">Software Development
                                            Lab</span>
                                    </div>
                                    <div
                                        class="flex items-center gap-6 shrink-0 text-xs font-medium text-zinc-500 dark:text-zinc-400">
                                        <span class="w-12 text-center">HND 2</span>
                                        <span class="w-12 text-right">Pract</span>
                                        <flux:button variant="ghost" size="sm" icon="trash"
                                            class="text-zinc-400 hover:text-red-600" />
                                    </div>
                                </div>

                                <div
                                    class="flex items-center justify-between py-2.5 px-4 hover:bg-zinc-50/50 dark:hover:bg-zinc-800/20 text-sm">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <span
                                            class="font-mono font-bold text-zinc-500 dark:text-zinc-400 w-16 shrink-0">CSC101</span>
                                        <span class="text-zinc-800 dark:text-zinc-200 truncate">Intro to Computer
                                            Science</span>
                                    </div>
                                    <div
                                        class="flex items-center gap-6 shrink-0 text-xs font-medium text-zinc-500 dark:text-zinc-400">
                                        <span class="w-12 text-center">ND 1</span>
                                        <span class="w-12 text-right">Theo</span>
                                        <flux:button variant="ghost" size="sm" icon="trash"
                                            class="text-zinc-400 hover:text-red-600" />
                                    </div>
                                </div>

                            </div>
                        </flux:table.cell>
                    </flux:table.row>

                    {{-- Row Block 2 --}}
                    <flux:table.row class="align-top">
                        <flux:table.cell class="py-3">
                            <div class="font-semibold text-zinc-900 dark:text-white">Dr. Jane Smith</div>
                            <div class="text-xs text-zinc-400 mt-0.5">1 allocation</div>
                        </flux:table.cell>

                        <flux:table.cell class="p-0">
                            <div class="w-full">
                                <div
                                    class="flex items-center justify-between py-2.5 px-4 hover:bg-zinc-50/50 dark:hover:bg-zinc-800/20 text-sm">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <span
                                            class="font-mono font-bold text-zinc-500 dark:text-zinc-400 w-16 shrink-0">CSC203</span>
                                        <span class="text-zinc-800 dark:text-zinc-200 truncate">Data Structures &
                                            Algos</span>
                                    </div>
                                    <div
                                        class="flex items-center gap-6 shrink-0 text-xs font-medium text-zinc-500 dark:text-zinc-400">
                                        <span class="w-12 text-center">ND 2</span>
                                        <span class="w-12 text-right">Theo</span>
                                        <flux:button variant="ghost" size="sm" icon="trash"
                                            class="text-zinc-400 hover:text-red-600" />
                                    </div>
                                </div>
                            </div>
                        </flux:table.cell>
                        </flux:row>
                </flux:table.rows>
            </flux:table>
        </flux:card>
    </div>
</x-layouts::app>
