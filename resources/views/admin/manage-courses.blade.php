<x-layouts::app :title="__('Manage Courses')">
    <div class="max-w-5xl mx-auto space-y-8 pb-12">
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">Manage Courses</flux:heading>
                <flux:subheading>Create and manage courses offered</flux:subheading>
            </div>
        </div>

        {{-- Course Management Card --}}
        <flux:card class="bg-zinc-50/80 dark:bg-zinc-900/50 border-zinc-200/60 shadow-sm">
            <div class="flex items-center gap-2 mb-6">
                <flux:icon name="book-open" variant="outline" class="text-zinc-400" />
                <flux:heading size="lg">Create Management</flux:heading>
            </div>

            {{-- Add Course Form --}}
            <div
                class="grid grid-cols-1 md:grid-cols-6 gap-4 items-end mb-8 bg-white/50 dark:bg-white/[0.02] p-4 rounded-xl border border-zinc-200/50">
                <div class="md:col-span-2">
                    <flux:input label="Course Name" placeholder="e.g Backend Development 2" />
                </div>

                <flux:input label="Course Code" placeholder="e.g SWD413" />

                {{-- Practical Checkbox - Vertical alignment is handled by 'items-end' on the parent grid --}}
                <div class="flex items-center pb-3">
                    <flux:checkbox label="Practical"
                        description="Mark if this course is the practical of the above course" />
                </div>

                <flux:select label="Level" placeholder="Level">
                    <flux:select.option>HND1</flux:select.option>
                    <flux:select.option>HND2</flux:select.option>
                </flux:select>

                <flux:select label="Option (Optional)" placeholder="Select Option">
                    <flux:select.option>Software And Web Development</flux:select.option>
                    <flux:select.option>Cyber Security</flux:select.option>
                </flux:select>

                <div class="md:col-span-6 flex justify-end mt-2">
                    <flux:button variant="primary" icon="plus" class="w-full md:w-auto">
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
                    <flux:table.row>
                        <flux:table.cell>
                            <div class="flex items-center gap-3">
                                <div class="flex flex-col">
                                    <span class="font-medium">Backend Development 2</span>
                                    <span class="text-xs text-zinc-500 uppercase">
                                        SWD413
                                    </span>
                                    <div class="flex items-center mt-1">
                                        <flux:badge color="emerald" size="sm" variant="flat">Practical</flux:badge>
                                    </div>
                                </div>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell align="center">
                            <flux:badge color="zinc" variant="outline">HND2</flux:badge>
                        </flux:table.cell>
                        <flux:table.cell align="center" class="text-zinc-600 dark:text-zinc-400">
                            Software And Web Development
                        </flux:table.cell>
                        <flux:table.cell align="center">
                            <flux:modal.trigger name="edit-course">
                                <flux:button variant="ghost" size="sm" icon="pencil-square">Edit</flux:button>
                            </flux:modal.trigger>
                        </flux:table.cell>
                        </flux:row>
                        <flux:table.row>
                            <flux:table.cell>
                                <div class="flex flex-col">
                                    <span class="font-medium">Backend Development 2</span>
                                    <span class="text-xs text-zinc-500 uppercase">
                                        SWD413
                                    </span>
                                </div>
                            </flux:table.cell>
                            <flux:table.cell align="center">
                                <flux:badge color="zinc" variant="outline">HND2</flux:badge>
                            </flux:table.cell>
                            <flux:table.cell align="center" class="text-zinc-600 dark:text-zinc-400">
                                Software And Web Development
                            </flux:table.cell>
                            <flux:table.cell align="center">
                                <flux:modal.trigger name="edit-course">
                                    <flux:button variant="ghost" size="sm" icon="pencil-square">Edit</flux:button>
                                </flux:modal.trigger>
                            </flux:table.cell>
                            </flux:row>
                </flux:table.rows>
            </flux:table>
        </flux:card>
    </div>

    {{-- Edit Course Modal --}}
    <flux:modal name="edit-course" class="md:w-[550px] space-y-6">
        <div>
            <flux:heading size="lg">Edit Course Details</flux:heading>
            <flux:subheading>Modify course settings for the current semester.</flux:subheading>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <flux:input label="Course Name" value="Backend Development 2" />
            </div>

            <flux:input label="Course Code" value="SWD412" />

            {{-- Practical Checkbox --}}
            <div class="flex items-center">
                <flux:checkbox label="Practical Course" checked
                    description="Mark if this course is the practical of the above course" />
            </div>

            <flux:select label="Level">
                <flux:select.option selected>HND2</flux:select.option>
                <flux:select.option>HND1</flux:select.option>
            </flux:select>

            <div class="md:col-span-1">
                <flux:select label="Course Option (Optional)">
                    <flux:select.option selected>Software And Web Development</flux:select.option>
                    <flux:select.option>None</flux:select.option>
                </flux:select>
            </div>
        </div>

        <div class="flex flex-col-reverse md:flex-row justify-between gap-3 mt-6">
            <flux:button variant="ghost" icon="trash" style="color: #dc2626; border: 1px dashed #dc2626;">
                Remove Course
            </flux:button>

            <div class="flex gap-2">
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary">Update Course</flux:button>
            </div>
        </div>
    </flux:modal>
</x-layouts::app>
