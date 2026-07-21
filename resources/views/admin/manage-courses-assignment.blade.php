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
        <livewire:admin.course-assignment.new-assignment />
    </div>
</x-layouts::app>
