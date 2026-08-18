<div>
    {{-- Course Overview Summary Card --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 border-zinc-200 dark:border-zinc-800 pt-6">
        <div
            class="p-4 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-100 dark:border-zinc-800 shadow-sm flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h4 class="font-bold text-sm text-zinc-800 dark:text-zinc-200">
                        {{ $course->course_name ?? 'Course Name' }}
                    </h4>
                    <span class="text-xs text-zinc-500">
                        {{ $course->course_code ?? 'CODE' }} | {{ $course->type ?? 'General' }}
                    </span>
                </div>
                <flux:badge size="sm" variant="flat" color="zinc">
                    {{ $course->students_count ?? 0 }} Students
                </flux:badge>
            </div>

            <div class="space-y-2">
                <flux:badge size="sm" variant="flat" color="zinc">
                    {{ $course->sessions_count ?? 0 }}
                    {{ \Illuminate\Support\Str::plural('class', $course->sessions_count ?? 0) }}
                </flux:badge>

                <div class="flex justify-between text-[10px] uppercase font-bold text-zinc-400 tracking-wider">
                    <span>Overall Attendance Avg.</span>
                    <span class="text-emerald-500">{{ $overallAveragePct }}%</span>
                </div>

                <div class="w-full bg-zinc-100 dark:bg-zinc-800 rounded-full h-1.5">
                    <div class="bg-emerald-500 h-1.5 rounded-full transition-all duration-300"
                        style="width: {{ $overallAveragePct }}%"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sessions Table Card --}}
    <flux:card class="bg-white dark:bg-zinc-900 border-zinc-200/60 shadow-sm mt-6">
        <div
            class="p-6 border-b border-zinc-100 dark:border-zinc-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <flux:heading size="lg">Class Sessions</flux:heading>
                <flux:subheading italic>History of all classes held for {{ $course->course_code }}.</flux:subheading>
            </div>

            <div class="flex items-center gap-3">
                <flux:button wire:click="exportCourseRegistryCsv" icon="document-arrow-down" variant="outline"
                    size="sm">
                    Export Course Registry
                </flux:button>
            </div>
        </div>

        <flux:table>
            <flux:table.columns>
                <flux:table.column sortable>Date</flux:table.column>
                <flux:table.column>Timeline</flux:table.column>
                <flux:table.column align="center">Students</flux:table.column>
                <flux:table.column align="center">Attendance Rate</flux:table.column>
                <flux:table.column align="right">Actions</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($sessions as $session)
                    @php
                        $startTime = $session->started_at ? \Carbon\Carbon::parse($session->started_at) : null;
                        $endTime = $session->ended_at ? \Carbon\Carbon::parse($session->ended_at) : null;

                        // Calculate session duration string
                        $durationStr = 'N/A';
                        if ($startTime && $endTime) {
                            $diff = $startTime->diff($endTime);
                            $durationStr = "{$diff->h}h {$diff->i}m";
                        } elseif ($session->is_active) {
                            $durationStr = 'In Progress';
                        }

                        // Calculate attendance rate
                        $enrolledCount = $course->enrolled_students_count ?: ($session->expected_students ?: 1);
                        $attendedCount = $session->records_count ?? 0;
                        $rate = min(100, round(($attendedCount / max(1, $enrolledCount)) * 100));
                    @endphp

                    <flux:table.row wire:key="session-row-{{ $session->id }}">
                        {{-- Date Column --}}
                        <flux:table.cell>
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex flex-col items-center justify-center size-10 rounded-lg bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700">
                                    <span class="text-[10px] uppercase font-bold text-zinc-500">
                                        {{ $startTime ? $startTime->format('M') : 'N/A' }}
                                    </span>
                                    <span class="text-sm font-black text-zinc-800 dark:text-zinc-200">
                                        {{ $startTime ? $startTime->format('d') : '--' }}
                                    </span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-semibold text-zinc-800 dark:text-zinc-200">
                                        {{ $startTime ? $startTime->format('l') : 'N/A' }}
                                    </span>
                                    <span class="text-[10px] text-zinc-400">
                                        {{ $startTime ? $startTime->format('Y') : '' }}
                                    </span>
                                </div>
                            </div>
                        </flux:table.cell>

                        {{-- Timeline --}}
                        <flux:table.cell>
                            <div class="flex flex-col">
                                <div class="flex items-center gap-1.5 text-zinc-700 dark:text-zinc-300">
                                    <flux:icon name="clock" variant="micro" class="text-zinc-400" />
                                    <span class="text-sm font-medium">
                                        {{ $startTime ? $startTime->format('h:i A') : '--:--' }}
                                        -
                                        {{ $endTime ? $endTime->format('h:i A') : ($session->is_active ? 'Present' : '--:--') }}
                                    </span>
                                </div>
                                <span class="text-[10px] text-zinc-500 mt-0.5">Duration: {{ $durationStr }}</span>
                            </div>
                        </flux:table.cell>

                        {{-- Number of Students Present --}}
                        <flux:table.cell align="center">
                            <div class="flex flex-col items-center">
                                <span class="text-sm font-bold text-zinc-800 dark:text-zinc-200">
                                    {{ $attendedCount }}
                                </span>
                                <span class="text-[9px] text-zinc-400 uppercase tracking-tighter">Present</span>
                            </div>
                        </flux:table.cell>

                        {{-- Attendance Rate --}}
                        <flux:table.cell align="center">
                            <div class="flex flex-col items-center gap-1">
                                <div class="flex items-baseline gap-1">
                                    <span
                                        class="text-sm font-black {{ $rate >= 75 ? 'text-emerald-600 dark:text-emerald-400' : 'text-zinc-600 dark:text-zinc-400' }}">
                                        {{ $rate }}%
                                    </span>
                                </div>
                                <div class="w-16 bg-zinc-100 dark:bg-zinc-800 h-1 rounded-full overflow-hidden">
                                    <div class="bg-emerald-500 h-full transition-all duration-300"
                                        style="width: {{ $rate }}%"></div>
                                </div>
                            </div>
                        </flux:table.cell>

                        {{-- Actions --}}
                        <flux:table.cell align="right">
                            <div class="flex justify-end gap-2">
                                <flux:button wire:click="exportSessionCsv({{ $session->id }})" variant="ghost"
                                    size="sm" icon="arrow-down-tray" tooltip="Download CSV" />

                                {{-- Route points to the session class details view --}}
                                <flux:button link :href="route('lecturer.classdetails', [$session->id])"
                                    variant="subtle" size="sm" icon="chevron-right" icon-trailing>
                                    View Details
                                </flux:button>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="5" class="text-center py-8 text-zinc-500">
                            No class sessions found for this course.
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

        @if ($sessions->hasPages())
            <div class="p-4 border-t border-zinc-100 dark:border-zinc-800">
                {{ $sessions->links() }}
            </div>
        @endif
    </flux:card>
</div>
