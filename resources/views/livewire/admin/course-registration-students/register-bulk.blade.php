<div>
    <div class="space-y-12">
        {{-- File Upload Form --}}
        <flux:card class="bg-zinc-50 dark:bg-white/5 border-dashed border-2 relative">
            <div class="space-y-4">
                <div>
                    <flux:heading size="lg">Bulk Course Enrollment</flux:heading>
                    <flux:subheading>Upload a CSV mapped with course registration keys.</flux:subheading>
                </div>

                <div class="group relative flex flex-col items-center justify-center p-6 border-2 border-dashed border-zinc-300 dark:border-zinc-700 rounded-xl hover:border-blue-500 transition-colors cursor-pointer">
                    <flux:icon name="document-arrow-up" class="mb-2 text-zinc-400 group-hover:text-blue-500" />
                    <span class="text-xs text-zinc-500 text-center">Drag and drop CSV or click to browse</span>
                    <input type="file" wire:model="file" class="absolute inset-0 opacity-0 cursor-pointer">
                </div>

                @if (session('success'))
                    <div class="text-green-600 text-sm font-semibold">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            {{-- Loading State --}}
            <div wire:loading wire:target="file" class="absolute inset-0 flex items-center justify-center bg-white/60 dark:bg-black/40 backdrop-blur-sm rounded-xl">
                <div class="flex flex-col items-center gap-2">
                    <div class="w-8 h-8 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
                    <p class="text-sm font-medium text-blue-500">Processing File...</p>
                </div>
            </div>
        </flux:card>
    </div>

    {{-- Staging Queue View --}}
    @if (count($rows))
        <flux:card class="p-0 overflow-hidden bg-zinc-50/80 dark:bg-zinc-900/50 border-zinc-200/60 shadow-sm backdrop-blur-md mt-6">
            <div class="p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-zinc-200/50 dark:border-white/5">
                <div>
                    <div class="flex items-center gap-2">
                        <flux:heading size="lg">Review Registration Queue</flux:heading>
                        <flux:badge color="orange" size="sm">Draft Mode</flux:badge>
                    </div>
                    <flux:subheading>Verify course details before triggering queued background inserts.</flux:subheading>
                </div>

                @if (session('error'))
                    <div class="text-red-600 text-sm font-medium">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="flex items-center gap-2 w-full md:w-auto">
                    <flux:button wire:click="clearQueue" variant="ghost" color="red" icon="trash" size="sm">
                        Clear Queue
                    </flux:button>
                    <flux:button wire:click="finalize" variant="primary" icon="plus" class="px-6">
                        Finalize & Process Registration
                    </flux:button>
                </div>
            </div>

            <div class="overflow-x-auto px-1">
                <table class="w-full text-left text-xs text-zinc-600 dark:text-zinc-300 min-w-[1200px]">
                    <thead class="bg-zinc-100/70 dark:bg-zinc-800/50 border-b uppercase text-[11px] font-semibold text-zinc-500">
                        <tr>
                            <th class="p-4">App / Matric No</th>
                            <th class="p-4">Level</th>
                            <th class="p-4">Course Option</th>
                            <th class="p-4">Session</th>
                            <th class="p-4">Semester</th>
                            <th class="p-4">Programme</th>
                            <th class="p-4">Course Name / Code</th>
                            <th class="p-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200/60 dark:divide-zinc-800">
                        @foreach ($this->paginatedRows as $index => $row)
                            <tr class="hover:bg-zinc-100/50 dark:hover:bg-white/5 transition-colors">
                                <td class="p-3">
                                    <input type="text" wire:model="rows.{{ ($page - 1) * $perPage + $index }}.application_number"
                                        class="w-full bg-transparent border border-zinc-200 rounded px-2 py-1 focus:ring-1 focus:ring-blue-500">
                                </td>
                                <td class="p-3">
                                    <input type="text" wire:model="rows.{{ ($page - 1) * $perPage + $index }}.level"
                                        class="w-full bg-transparent border border-zinc-200 rounded px-2 py-1 focus:ring-1 focus:ring-blue-500">
                                </td>
                                <td class="p-3">
                                    <input type="text" wire:model="rows.{{ ($page - 1) * $perPage + $index }}.course_option"
                                        class="w-full bg-transparent border border-zinc-200 rounded px-2 py-1 focus:ring-1 focus:ring-blue-500">
                                </td>
                                <td class="p-3">
                                    <input type="text" wire:model="rows.{{ ($page - 1) * $perPage + $index }}.academic_session"
                                        class="w-full bg-transparent border border-zinc-200 rounded px-2 py-1 focus:ring-1 focus:ring-blue-500">
                                </td>
                                <td class="p-3">
                                    <input type="text" wire:model="rows.{{ ($page - 1) * $perPage + $index }}.semester"
                                        class="w-full bg-transparent border border-zinc-200 rounded px-2 py-1 focus:ring-1 focus:ring-blue-500">
                                </td>
                                <td class="p-3">
                                    <input type="text" wire:model="rows.{{ ($page - 1) * $perPage + $index }}.programme"
                                        class="w-full bg-transparent border border-zinc-200 rounded px-2 py-1 focus:ring-1 focus:ring-blue-500">
                                </td>
                                <td class="p-3">
                                    <input type="text" wire:model="rows.{{ ($page - 1) * $perPage + $index }}.course_name"
                                        class="w-full bg-transparent border border-zinc-200 rounded px-2 py-1 focus:ring-1 focus:ring-blue-500">
                                </td>
                                <td class="p-3 text-center">
                                    <flux:button wire:click="removeRow({{ ($page - 1) * $perPage + $index }})" 
                                        variant="ghost" color="red" icon="x-mark" size="sm" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination Footer --}}
            <div class="p-4 bg-zinc-100/50 dark:bg-white/5 border-t border-zinc-200/50 flex justify-between items-center text-xs text-zinc-500">
                <p>
                    Showing <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ ($page - 1) * $perPage + 1 }}</span>
                    to <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ min($page * $perPage, count($rows)) }}</span>
                    of <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ count($rows) }}</span> queue rows
                </p>

                <div class="flex items-center gap-2">
                    <button wire:click="$set('page', {{ max(1, $page - 1) }})" 
                        @if ($page <= 1) disabled @endif 
                        class="px-3 py-1 border rounded bg-white dark:bg-zinc-800 disabled:opacity-50">
                        &larr; Previous
                    </button>
                    <button wire:click="$set('page', {{ $page + 1 }})" 
                        @if ($page * $perPage >= count($rows)) disabled @endif 
                        class="px-3 py-1 border rounded bg-white dark:bg-zinc-800 disabled:opacity-50">
                        Next &rarr;
                    </button>
                </div>
            </div>
        </flux:card>
    @endif
</div>