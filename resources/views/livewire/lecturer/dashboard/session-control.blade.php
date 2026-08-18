<div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Control Section --}}
        <div class="lg:col-span-2 space-y-6">
            <flux:card class="bg-white dark:bg-zinc-900 border-zinc-200 dark:border-zinc-800 shadow-sm">
                <div>
                    {{-- Header --}}
                    <div class="flex items-center justify-between">
                        <div>
                            <flux:heading size="lg">Class Session Control</flux:heading>
                            <flux:subheading>Manage your current classroom presence.</flux:subheading>
                        </div>

                        @if ($activeSession)
                            <flux:badge color="emerald" variant="flat" class="animate-pulse">
                                Active: {{ $activeSession->course->course_code }}
                            </flux:badge>
                        @else
                            <flux:badge color="zinc" variant="flat">
                                Inactive
                            </flux:badge>
                        @endif
                    </div>

                    @if ($activeSession)
                        {{-- ACTIVE SESSION DISPLAY --}}
                        <div class="mt-6 space-y-6">
                            {{-- Course Banner --}}
                            <div
                                class="p-4 rounded-xl bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700">
                                <p class="text-xs uppercase font-bold text-zinc-500 tracking-wider">Active Course</p>
                                <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">
                                    {{ $activeSession->course->course_name }}
                                    ({{ $activeSession->course->course_code }})
                                </h3>
                            </div>

                            {{-- Time Information Grid --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div
                                    class="p-4 rounded-xl bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700">
                                    <p class="text-xs font-bold uppercase text-zinc-500">Started At</p>
                                    <p class="text-base font-semibold text-zinc-800 dark:text-zinc-200 mt-1">
                                        {{ \Carbon\Carbon::parse($activeSession->started_at)->format('g:i A') }}
                                    </p>
                                </div>
                                <div
                                    class="p-4 rounded-xl bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700">
                                    <p class="text-xs font-bold uppercase text-zinc-500">Scheduled End Time</p>
                                    <p class="text-base font-semibold text-zinc-800 dark:text-zinc-200 mt-1">
                                        {{ $activeSession->ended_at ? \Carbon\Carbon::parse($activeSession->ended_at)->format('g:i A') : 'Manual Stop' }}
                                    </p>
                                </div>
                            </div>

                            {{-- Code Display Box & Copy Action --}}
                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase tracking-wider text-zinc-500">
                                    Attendance Entry Code
                                </label>

                                <div class="flex items-center gap-2" x-data="{
                                    copied: false,
                                    copyCode() {
                                        const input = $refs.codeBox;
                                        input.select();
                                        input.setSelectionRange(0, 99999); // Mobile support
                                
                                        if (navigator.clipboard && window.isSecureContext) {
                                            navigator.clipboard.writeText(input.value);
                                        } else {
                                            document.execCommand('copy');
                                        }
                                
                                        this.copied = true;
                                        setTimeout(() => this.copied = false, 2500);
                                    }
                                }">
                                    <div
                                        class="flex-1 bg-zinc-100 dark:bg-zinc-800/80 rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                                        <input x-ref="codeBox" type="text" readonly
                                            value="{{ $activeSession->attendance_code }}"
                                            class="w-full py-4 px-6 bg-transparent text-center text-3xl font-mono font-black tracking-widest text-emerald-600 dark:text-emerald-400 focus:outline-none border-none select-all cursor-pointer"
                                            @click="copyCode()" />
                                    </div>

                                    <flux:button variant="primary" icon="clipboard" class="h-full min-h-[58px] px-5 py-5"
                                        x-on:click="copyCode()">
                                        <span x-text="copied ? 'Copied!' : 'Copy Code'"></span>
                                    </flux:button>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- INACTIVE SESSION FORM --}}
                        <div class="mt-6 space-y-6">
                            {{-- Course Select --}}
                            <flux:select wire:model.live="selectedCourseId" label="Select Course"
                                placeholder="Select a course...">
                                @foreach ($assignedCourses as $course)
                                    <flux:select.option value="{{ $course->id }}">
                                        {{ $course->course_name }} ({{ $course->course_code }})
                                    </flux:select.option>
                                @endforeach
                            </flux:select>

                            {{-- Session End Time Input Block --}}
                            <div class="space-y-2">
                                <label for="session_end" class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                    Class Session End Time (Optional)
                                </label>

                                <div class="flex items-stretch gap-2">
                                    <div
                                        class="flex items-center justify-center px-3 bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg text-zinc-500 dark:text-zinc-400 shadow-sm">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                    </div>

                                    <div class="relative flex-1 rounded-lg shadow-sm">
                                        <input type="time" id="session_end" wire:model="sessionEnd"
                                            class="w-full p-3 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg text-zinc-800 dark:text-zinc-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 cursor-pointer">
                                    </div>
                                </div>
                                @error('sessionEnd')
                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Action Button --}}
                            <div class="flex gap-3">
                                <flux:button wire:click="startSession" variant="primary" class="flex-1"
                                    icon="play-circle">
                                    Start New Session
                                </flux:button>
                            </div>
                            <span class="block text-xs font-medium text-zinc-500">
                                All other active sessions under your account will automatically close when a new one
                                starts.
                            </span>
                        </div>
                    @endif
                </div>
            </flux:card>
        </div>

        {{-- Right Live Stats Panel --}}
        <div class="space-y-6">
            @if ($activeSession)
                @php
                    $expected = $activeSession->expected_students ?: 1;
                    $percent = min(round(($liveCheckInsCount / $expected) * 100), 100);
                @endphp

                <flux:card class="bg-emerald-50/50 dark:bg-transparent border-emerald-100 dark:border-emerald-900/30">
                    <div class="flex flex-col gap-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-emerald-500 rounded-lg">
                                <flux:icon name="users" class="text-white size-5" />
                            </div>
                            <div>
                                <p class="text-sm font-bold text-emerald-900 dark:text-emerald-400">Live Check-ins</p>
                                <p class="text-3xl font-black text-emerald-700 dark:text-emerald-300">
                                    {{ $liveCheckInsCount }}
                                    <span class="text-sm font-normal opacity-60">/
                                        {{ $activeSession->expected_students }}</span>
                                </p>
                            </div>
                        </div>

                        <div class="w-full bg-emerald-200 dark:bg-emerald-800 rounded-full h-2">
                            <div class="bg-emerald-600 h-2 rounded-full transition-all duration-500"
                                style="width: {{ $percent }}%"></div>
                        </div>

                        <p class="text-[10px] text-emerald-600 dark:text-emerald-500 font-medium italic">
                            Last check-in: {{ $lastCheckIn }}
                        </p>
                    </div>
                </flux:card>

                <flux:card class="border-zinc-200 dark:border-zinc-800">
                    <flux:button wire:click="endSession" wire:confirm="Are you sure you want to end this live session?"
                        variant="danger" class="w-full" icon="stop-circle">
                        End Current Session
                    </flux:button>
                </flux:card>
            @else
                <flux:card class="border-zinc-200 dark:border-zinc-800 text-center py-8">
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">
                        No active session running. Pick a course and click <strong>Start New Session</strong> to start
                        tracking attendance.
                    </p>
                </flux:card>
            @endif
        </div>
    </div>
</div>
