<x-layouts::app :title="__('Student Enrollment')">
    <style>
        .cell-input {
            width: 100%;
            background: transparent;
            border: 1px solid transparent;
            padding: 6px 8px;
            border-radius: 6px;
            outline: none;
            transition: all 0.2s;
        }

        .cell-input:focus {
            border-color: #3b82f6;
            background: #f8fafc;
        }

        .dark .cell-input:focus {
            background: rgba(255, 255, 255, 0.05);
        }

        .cell-select {
            width: 100%;
            background: transparent;
            border: 1px solid transparent;
            padding: 6px 8px;
            border-radius: 6px;
            outline: none;
        }

        .cell-select:focus {
            border-color: #3b82f6;
        }

        table {
            border-collapse: collapse;
        }

        .w-full::-webkit-scrollbar {
            height: 8px;
        }

        .w-full::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .dark .w-full::-webkit-scrollbar-thumb {
            background: #334155;
        }
    </style>

    <div class="space-y-8 max-w-7xl mx-auto pb-10">

        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">Student Enrollment</flux:heading>
                <flux:subheading>Manage single entries or bulk upload student records.</flux:subheading>
            </div>
            <livewire:admin.student.csv-template />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- single enrollment --}}
            <livewire:admin.student.single-enrollment />
        </div>

        {{-- bulk enrollment --}}
        <livewire:admin.student.bulk-enrollment />

        <livewire:admin.student.view-data />
    </div>
    <script>
        document.addEventListener('keydown', function(e) {

            const active = document.activeElement;

            if (!active.classList.contains('cell-input')) return;

            const td = active.closest('td');
            const tr = td.closest('tr');

            if (e.key === 'Enter') {
                e.preventDefault();

                let next = td.nextElementSibling;

                if (next) {
                    let input = next.querySelector('input, select');
                    if (input) input.focus();
                } else {
                    let nextRow = tr.nextElementSibling;
                    if (nextRow) {
                        let first = nextRow.querySelector('input, select');
                        if (first) first.focus();
                    }
                }
            }

        });
    </script>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('csv-loaded', () => {
                document.getElementById('review-table')
                    ?.scrollIntoView({
                        behavior: 'smooth'
                    });
            });
        });
    </script>
</x-layouts::app>
