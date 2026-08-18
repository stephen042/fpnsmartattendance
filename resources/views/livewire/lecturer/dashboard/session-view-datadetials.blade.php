<div>
    {{-- Course & Session Info Header Card --}}
    <flux:card class="bg-zinc-50/80 dark:bg-zinc-900/50 border-zinc-200/60 shadow-sm">
        <div>
            <div class="flex items-end justify-between mb-6">
                <div>
                    @if ($session->is_active)
                        <flux:badge size="lg" color="emerald" variant="flat" class="animate-pulse">
                            Active: {{ $session->course->course_code ?? 'Course' }}
                        </flux:badge>
                    @else
                        <flux:badge size="lg" color="zinc" variant="flat">
                            Closed: {{ $session->course->course_code ?? 'Course' }}
                        </flux:badge>
                    @endif
                </div>

                @if ($currentSemester)
                    <flux:badge variant="flat" color="blue">
                        {{ $currentSemester }}
                    </flux:badge>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 border-zinc-200 dark:border-zinc-800 pt-6">
                <div
                    class="p-4 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-100 dark:border-zinc-800 shadow-sm flex flex-col justify-between">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h4 class="font-bold text-sm text-zinc-800 dark:text-zinc-200">
                                {{ $session->course->course_name ?? 'N/A' }}
                            </h4>
                            <span class="text-xs text-zinc-500">
                                {{ $session->course->course_code ?? '' }}
                                {{ isset($session->course->type) ? '| ' . $session->course->type : '' }}
                            </span>
                        </div>
                        <flux:badge size="sm" variant="flat" color="zinc">
                            {{ $stats['total_students'] }} Students
                        </flux:badge>
                    </div>

                    <div class="space-y-2">
                        <flux:badge size="sm" variant="flat" color="zinc">
                            {{ $stats['total_classes'] }}
                            {{ \Illuminate\Support\Str::plural('class', $stats['total_classes']) }}
                        </flux:badge>

                        <div class="flex justify-between text-[10px] uppercase font-bold text-zinc-400 tracking-wider">
                            <span>Attendance Avg. For This Class Session</span>
                            <span class="text-emerald-500">{{ $stats['attendance_avg'] }}%</span>
                        </div>

                        <div class="w-full bg-zinc-100 dark:bg-zinc-800 rounded-full h-1.5">
                            <div class="bg-emerald-500 h-1.5 rounded-full"
                                style="width: {{ $stats['attendance_avg'] }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </flux:card>

    {{-- Attendance Records Table --}}
    <flux:card class="bg-white dark:bg-zinc-900 border-zinc-200/60 shadow-sm mt-6">
        <flux:table>
            <flux:table.columns>
                <flux:table.column sortable>Student Info</flux:table.column>
                <flux:table.column>Identifiers</flux:table.column>
                <flux:table.column align="center">Sign-in Time</flux:table.column>
                <flux:table.column align="right">Actions</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($records as $record)
                    @php
                        // Derive student initials for avatar fallback
                        $studentName = $record->student->name ?? 'Unknown Student';
                        $words = explode(' ', trim($studentName));
                        $initials =
                            count($words) >= 2
                                ? strtoupper(substr($words[0], 0, 1) . substr(end($words), 0, 1))
                                : strtoupper(substr($studentName, 0, 2));

                        // Calculate time elapsed since session start
                        $signedInAt = $record->signed_in_at ? \Carbon\Carbon::parse($record->signed_in_at) : null;
                        $startedAt = $session->started_at ? \Carbon\Carbon::parse($session->started_at) : null;
                        $minutesAfter = $signedInAt && $startedAt ? $signedInAt->diffInMinutes($startedAt) : null;
                    @endphp

                    <flux:table.row wire:key="record-{{ $record->id }}">
                        {{-- Student Name & Avatar --}}
                        <flux:table.cell>
                            <div class="flex items-center gap-3">
                                <flux:avatar :initials="$initials" size="xs"
                                    class="bg-zinc-100 dark:bg-zinc-800" />
                                <div class="flex flex-col">
                                    <span class="font-semibold text-zinc-800 dark:text-zinc-200 uppercase">
                                        {{ $studentName }}
                                    </span>
                                    @if ($record->verified_geolocation)
                                        <span class="text-[10px] text-emerald-600 font-medium">Verified
                                            Geolocation</span>
                                    @else
                                        <span class="text-[10px] text-zinc-400 font-medium">Unverified Location</span>
                                    @endif
                                </div>
                            </div>
                        </flux:table.cell>

                        {{-- Application & Matric Numbers --}}
                        <flux:table.cell>
                            <div class="flex flex-col text-xs">
                                <span class="text-zinc-700 dark:text-zinc-300 font-mono">
                                    {{ $record->student->application_no ?? 'N/A' }}
                                </span>
                                <span class="text-zinc-500 text-[10px] uppercase">
                                    Matric: {{ $record->student->matric_no ?? 'N/A' }}
                                </span>
                            </div>
                        </flux:table.cell>

                        {{-- Specific Time of Sign-in --}}
                        <flux:table.cell align="center">
                            <div class="flex flex-col items-center">
                                <span class="text-sm font-medium text-zinc-800 dark:text-zinc-200">
                                    {{ $signedInAt ? $signedInAt->format('h:i A') : '--:--' }}
                                </span>
                                @if (!is_null($minutesAfter))
                                    <span class="text-[9px] text-zinc-400 uppercase tracking-tighter">
                                        {{ $minutesAfter }}
                                        {{ \Illuminate\Support\Str::plural('min', $minutesAfter) }} after start
                                    </span>
                                @endif
                            </div>
                        </flux:table.cell>

                        {{-- Action: Suspend / Unsuspend Student --}}
                        <flux:table.cell align="right">
                            <div class="flex justify-end items-center gap-2">
                                @if ($record->status === 'suspended')
                                    <flux:button wire:click="toggleSuspension({{ $record->id }})" variant="ghost"
                                        size="sm" color="emerald" icon="user-plus"
                                        class="text-zinc-500 hover:text-emerald-600 dark:text-zinc-400 dark:hover:text-emerald-400">
                                        Unsuspend
                                    </flux:button>
                                @else
                                    <flux:button wire:click="toggleSuspension({{ $record->id }})" variant="subtle"
                                        size="sm" color="red" icon="user-minus"
                                        class="hover:bg-red-100 dark:hover:bg-red-900/40" style="color: #ef4444">
                                        Suspend
                                    </flux:button>
                                @endif
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="4" class="text-center py-8 text-zinc-500">
                            No student attendance records recorded for this session yet.
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

        {{-- Pagination Links --}}
        @if ($records->hasPages())
            <div class="p-4 border-t border-zinc-100 dark:border-zinc-800">
                {{ $records->links() }}
            </div>
        @endif
    </flux:card>
</div>
