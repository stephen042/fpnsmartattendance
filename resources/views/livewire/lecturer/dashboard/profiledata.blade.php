<div>
    <flux:card class="bg-zinc-50/80 dark:bg-zinc-900/50 border-zinc-200/60 shadow-sm">
        <div>
            {{-- Header --}}
            <div class="flex items-end justify-between mb-6">
                <div>
                    <p class="text-sm font-medium opacity-70">Course(s) Assigned</p>
                    <p class="text-2xl font-bold mt-1">{{ $assignedCount }}</p>
                </div>
                <flux:badge variant="flat" color="blue">
                    {{ $currentSemester }}
                </flux:badge>
            </div>

            {{-- Course Grid --}}
            @if ($courses->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 border-t border-zinc-200 dark:border-zinc-800 pt-6">
                    @foreach ($courses as $course)
                        @php
                            $avg = $course['attendance_avg'];
                            if ($avg >= 80) {
                                $textColor = 'text-emerald-500';
                                $bgColor   = 'bg-emerald-500';
                            } elseif ($avg >= 50) {
                                $textColor = 'text-blue-500';
                                $bgColor   = 'bg-blue-500';
                            } else {
                                $textColor = 'text-amber-500';
                                $bgColor   = 'bg-amber-500';
                            }
                        @endphp

                        <div class="p-4 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-100 dark:border-zinc-800 shadow-sm flex flex-col justify-between">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="font-bold text-sm text-zinc-800 dark:text-zinc-200">
                                        {{ $course['name'] }}
                                    </h4>
                                    <span class="text-xs text-zinc-500">
                                        {{ $course['code'] }} | {{ $course['type'] }}
                                    </span>
                                </div>
                                <flux:badge size="sm" variant="flat" color="zinc">
                                    {{ $course['students_count'] }} {{ Str::plural('Student', $course['students_count']) }}
                                </flux:badge>
                            </div>

                            <div class="space-y-2">
                                <flux:badge size="sm" variant="flat" color="zinc">
                                    {{ $course['classes_count'] }} {{ Str::plural('class', $course['classes_count']) }}
                                </flux:badge>

                                <div class="flex justify-between text-[10px] uppercase font-bold text-zinc-400 tracking-wider">
                                    <span>Attendance Avg.</span>
                                    <span class="{{ $textColor }}">{{ $course['attendance_avg'] }}%</span>
                                </div>

                                <div class="w-full bg-zinc-100 dark:bg-zinc-800 rounded-full h-1.5">
                                    <div class="{{ $bgColor }} h-1.5 rounded-full transition-all duration-300" 
                                         style="width: {{ $course['attendance_avg'] }}%"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="border-t border-zinc-200 dark:border-zinc-800 pt-8 pb-4 text-center">
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">
                        No courses currently assigned to you for this semester.
                    </p>
                </div>
            @endif
        </div>
    </flux:card>
</div>