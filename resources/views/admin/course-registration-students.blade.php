<x-layouts::app :title="__('Student Course Enrollment')">
    <div class="space-y-8 max-w-7xl mx-auto pb-10">

        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">Student Course Enrollment</flux:heading>
                <flux:subheading>Register students into courses for active academic sessions and semesters.
                </flux:subheading>
            </div>
            <livewire:admin.course-registration-students.csv-template />
        </div>

        <div class="grid gap-8">

            <livewire:admin.course-registration-students.register-single />

        </div>
        
        <livewire:admin.course-registration-students.register-bulk />

        <livewire:admin.course-registration-students.register-data />
        
    </div>
</x-layouts::app>
