<div>
    <flux:card class="bg-white dark:bg-zinc-900 border-zinc-200/60 shadow-sm mt-6">
        {{-- Header & Actions --}}
        <div
            class="border-b border-zinc-100 dark:border-zinc-800 pb-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <flux:heading size="lg">Session History</flux:heading>
                <flux:subheading>Review and export past class attendance records.</flux:subheading>
            </div>

            <div class="flex items-center gap-3">
                <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass"
                    placeholder="Search course or date..." class="max-w-xs" />

                <flux:button wire:click="exportCsv" icon="document-arrow-down" variant="outline" size="sm">
                    Download CSV
                </flux:button>
            </div>
        </div>

        {{-- Table Content --}}
        <flux:table class="mt-4">
            <flux:table.columns>
                <flux:table.column sortable>Date & Time</flux:table.column>
                <flux:table.column>Course</flux:table.column>
                <flux:table.column align="center">Attendance</flux:table.column>
                <flux:table.column align="center">Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($sessions as $session)
                    <flux:table.row :key="$session->id">
                        {{-- Date & Time + Status --}}
                        <flux:table.cell class="text-zinc-800 dark:text-zinc-200 font-medium">
                            <div class="flex flex-col gap-2">
                                <div>
                                    {{ \Carbon\Carbon::parse($session->started_at)->format('F j, Y') }}
                                    <span class="block text-xs font-normal text-zinc-500">
                                        {{ \Carbon\Carbon::parse($session->started_at)->format('h:i A') }} -
                                        {{ $session->ended_at ? \Carbon\Carbon::parse($session->ended_at)->format('h:i A') : 'Ongoing' }}
                                    </span>
                                </div>

                                <div class="flex">
                                    @if ($session->is_active)
                                        <flux:badge color="emerald" variant="flat" class="animate-pulse">
                                            Active: {{ $session->course->course_code }}
                                        </flux:badge>
                                    @else
                                        <flux:badge color="zinc" variant="flat">
                                            Closed: {{ $session->course->course_code }}
                                        </flux:badge>
                                    @endif
                                </div>
                            </div>
                        </flux:table.cell>

                        {{-- Course Info --}}
                        <flux:table.cell>
                            <div class="flex flex-col">
                                <span class="font-medium">{{ $session->course->course_name }}</span>
                                <span class="text-xs text-zinc-500 uppercase">
                                    {{ $session->course->course_code }}
                                    {{ $session->course->type ? '• ' . $session->course->type : '' }}
                                </span>
                            </div>
                        </flux:table.cell>

                        {{-- Attendance Stats Cell --}}
                        <flux:table.cell align="center">
                            <flux:badge color="zinc" variant="outline">
                                {{ $session->records_count }} / {{ $session->expected_students ?? 0 }}
                            </flux:badge>
                        </flux:table.cell>

                        {{-- Actions --}}
                        <flux:table.cell align="center">
                            <flux:button link :href="route('lecturer.classdetails', [$session->id])" variant="ghost"
                                size="sm" icon="eye">
                                Full Report
                            </flux:button>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="4" class="text-center py-8 text-zinc-500 dark:text-zinc-400">
                            No attendance session records found.
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

        {{-- Pagination Links --}}
        @if ($sessions->hasPages())
            <div class="mt-4 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                {{ $sessions->links() }}
            </div>
        @endif
    </flux:card>
</div>
