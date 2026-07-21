<x-layouts::app :title="__('Edit Student')">
    <div class="max-w-7xl mx-auto space-y-8 pb-12">
        
        <livewire:admin.student.editstudent.edit :student-id="$id" />

        <livewire:admin.student.editstudent.attendance-history :student-id="$id" />
         
    </div>
</x-layouts::app>
