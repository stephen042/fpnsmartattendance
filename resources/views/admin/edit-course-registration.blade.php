<x-layouts::app :title="__('Edit Student Course Enrollment')">
    <div class="max-w-7xl mx-auto space-y-8 pb-12">

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <flux:button icon="arrow-left" variant="ghost" size="sm"
                    :href="route('course-registration-students')" />
                <div>
                    <flux:heading size="xl">Edit Course Registration</flux:heading>
                    <flux:subheading>
                        Modifying relationship record for <span class="text-zinc-800 dark:text-white font-medium">John
                            Doe (CS/2023/001)</span>
                    </flux:subheading>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <flux:button variant="ghost" size="sm" style="color:red; border:2px dashed red;">
                    Unenroll Student From Course
                </flux:button>
            </div>
        </div>

        <flux:card class="space-y-6 bg-zinc-50/80 dark:bg-zinc-900/50 border-zinc-200/60 dark:border-zinc-800">
            <div class="flex items-center gap-2">
                <flux:icon name="academic-cap" variant="outline" class="text-zinc-400" />
                <flux:heading size="lg">Registration Schema Assignment</flux:heading>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <flux:select label="Student" placeholder="Student Context" disabled>
                    <option value="1" selected>John Doe (CS/2023/001)</option>
                </flux:select>

                <flux:select label="Assigned Course Module *" placeholder="Select Course Module">
                    <option value="1" selected>Backend Development 2 (SWD413)</option>
                    <option value="2">Data Structures (SWD416)</option>
                    <option value="3">Cloud Architecture (CLC412)</option>
                </flux:select>

                <flux:select label="Academic Session *" placeholder="Choose Session">
                    <option value="1" selected>2025/2026 Academic Session</option>
                    <option value="2">2026/2027 Academic Session</option>
                </flux:select>

                <flux:select label="Semester *" placeholder="Choose Semester">
                    <option value="1" selected>First Semester</option>
                    <option value="2">Second Semester</option>
                </flux:select>
            </div>

            <div
                class="p-3 bg-zinc-100/50 dark:bg-zinc-800/30 rounded-lg border border-zinc-200/40 dark:border-zinc-700/40 text-xs text-zinc-500 flex items-center justify-between">
                <div>
                    <span>Registered By User ID:</span>
                    <strong
                        class="font-mono text-zinc-700 dark:text-zinc-300">#{{ $registration->registered_by ?? 1 }}</strong>
                </div>
                <div>
                    <span>Created:</span>
                    <strong class="font-mono text-zinc-700 dark:text-zinc-300">2026-05-28 14:22</strong>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:button variant="primary" icon="check-circle">Update Registration</flux:button>
                <flux:button variant="outline" icon="arrow-path">Undo Changes</flux:button>
            </div>
        </flux:card>
    </div>
</x-layouts::app>
