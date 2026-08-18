<div>
    <flux:card class="bg-white dark:bg-zinc-900 border-zinc-200/60 shadow-sm mt-6">
        <div
            class="p-6 border-b border-zinc-100 dark:border-zinc-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <flux:heading size="lg">Session History</flux:heading>
                <flux:subheading italic>Review and export past class attendance records.</flux:subheading>
            </div>

            <div class="flex items-center gap-3">
                <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass"
                    placeholder="Search course or date..." class="max-w-xs" clearable />
            </div>
        </div>

        <flux:table>
            <flux:table.columns>
                <flux:table.column sortable>Date & Time</flux:table.column>
                <flux:table.column>Course Details</flux:table.column>
                <flux:table.column align="center">Avg. Attendance</flux:table.column>
                <flux:table.column align="right">Actions</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($sessions as $session)
                    @php
                        // Format times safely
                        $startTime = $session->started_at ? \Carbon\Carbon::parse($session->started_at) : null;
                        $endTime = $session->ended_at ? \Carbon\Carbon::parse($session->ended_at) : null;

                        // Calculate percentage based on expected students vs recorded check-ins
                        $expected = $session->expected_students ?? 0;
                        $attended = $session->records_count ?? 0;
                        $attendancePct = $expected > 0 ? round(($attended / $expected) * 100) : 0;

                        // Total session count for this course up to now
                        $totalCourseSessions = \App\Models\AttendanceSession::where(
                            'course_id',
                            $session->course_id,
                        )->count();
                    @endphp

                    <flux:table.row wire:key="session-{{ $session->id }}">
                        {{-- Date, Time & Status Badge --}}
                        <flux:table.cell>
                            <div class="flex flex-col gap-1.5">
                                <span class="font-semibold text-zinc-800 dark:text-zinc-200">
                                    {{ $startTime ? $startTime->format('F d, Y') : 'N/A' }}
                                </span>
                                <span class="text-xs text-zinc-500 italic">
                                    {{ $startTime ? $startTime->format('h:i A') : '--:--' }}
                                    -
                                    {{ $endTime ? $endTime->format('h:i A') : ($session->is_active ? 'Present' : '--:--') }}
                                </span>
                                <div class="flex">
                                    @if ($session->is_active)
                                        <flux:badge color="emerald" variant="flat" size="sm" class="animate-pulse">
                                            Active Now
                                        </flux:badge>
                                    @else
                                        <flux:badge color="zinc" variant="flat" size="sm">
                                            Completed
                                        </flux:badge>
                                    @endif
                                </div>
                            </div>
                        </flux:table.cell>

                        {{-- Course Details --}}
                        <flux:table.cell>
                            <div class="flex flex-col">
                                <span class="font-bold text-zinc-800 dark:text-zinc-200">
                                    {{ $session->course->course_name ?? 'N/A' }}
                                </span>
                                <div class="flex items-center gap-2 mt-1">
                                    <flux:badge size="xs" variant="outline" color="zinc">
                                        {{ $session->course->course_code ?? 'N/A' }}
                                    </flux:badge>
                                    @if (isset($session->course->type))
                                        <span class="text-[10px] text-zinc-400 uppercase font-medium tracking-wider">
                                            {{ $session->course->type }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </flux:table.cell>

                        {{-- Attendance Stats --}}
                        <flux:table.cell align="center">
                            <div class="flex flex-col items-center gap-1">
                                <span
                                    class="text-sm font-bold {{ $attendancePct >= 75 ? 'text-emerald-600 dark:text-emerald-400' : 'text-zinc-600 dark:text-zinc-400' }}">
                                    {{ $attendancePct }}%
                                </span>
                                <flux:badge size="xs" variant="flat" color="zinc">
                                    {{ $totalCourseSessions }}
                                    {{ \Illuminate\Support\Str::plural('class', $totalCourseSessions) }}
                                </flux:badge>
                            </div>
                        </flux:table.cell>

                        {{-- Actions --}}
                        <flux:table.cell align="right">
                            <div class="flex justify-end gap-2">
                                <flux:button wire:click="exportSessionCsv({{ $session->id }})" variant="ghost"
                                    size="sm" icon="arrow-down-tray" tooltip="Export CSV" />

                                <flux:button link :href="route('lecturer.coursedetails', [$session->id])"
                                    variant="subtle" size="sm" icon="eye">
                                    Full Report
                                </flux:button>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="4" class="text-center py-8 text-zinc-500">
                            @if ($search)
                                No attendance sessions matching "<span class="font-medium">{{ $search }}</span>".
                            @else
                                No session history found.
                            @endif
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

        {{-- Pagination Links --}}
        @if ($sessions->hasPages())
            <div class="p-4 border-t border-zinc-100 dark:border-zinc-800">
                {{ $sessions->links() }}
            </div>
        @endif
    </flux:card>
</div>
