<div style="padding:20px;">

    <flux:card
        style="
        space-y:16px;
        padding:18px;
        border-radius:14px;
        border:1px solid #e4e4e7;
        background:#fafafa;
    ">

        {{-- HEADER --}}
        <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">

            <flux:heading size="lg">Enrolled Students</flux:heading>

            <div style="display:flex; align-items:center; gap:10px;">

                <div style="width:280px;">
                    <flux:input wire:model.live.debounce.500ms="search" placeholder="Search by name or App No..."
                        size="sm"
                        style="
                    border-radius:10px;
                    border:1px solid #e4e4e7;
                    padding:10px;
                    margin:8px 2px;
                " />
                </div>

                <flux:button wire:click="refreshData" wire:loading.attr="disabled" size="sm" variant="primary">
                    <span wire:loading.remove wire:target="refreshData">
                        🔄 Refresh
                    </span>

                    <span wire:loading wire:target="refreshData">
                        Refreshing...
                    </span>
                </flux:button>

            </div>

        </div>

        {{-- TABLE WRAPPER --}}
        <div style="overflow-x:auto; border-radius:12px; border:1px solid #e4e4e7;" wire:poll.15s>

            <table style="width:100%; min-width:1000px; border-collapse:collapse; font-size:13px;">

                {{-- HEADER --}}
                <thead
                    style="background:#f4f4f5; text-transform:uppercase; font-size:11px; letter-spacing:0.05em; color:#71717a;">
                    <tr>

                        <th style="padding:12px;">App No</th>
                        <th style="padding:12px;">Full Name</th>
                        <th style="padding:12px;">Level</th>
                        <th style="padding:12px;">Program</th>
                        <th style="padding:12px;">Option</th>
                        <th style="padding:12px;">Mat No</th>
                        <th style="padding:12px; text-align:right;">Action</th>

                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody>

                    @forelse($students as $student)
                        <tr style="border-bottom:1px solid #f1f5f9; transition:0.2s;"
                            onmouseover="this.style.background='#f8fafc'"
                            onmouseout="this.style.background='transparent'">

                            <td style="padding:12px; font-family:monospace;">
                                {{ $student->application_number }}
                            </td>

                            <td style="padding:12px; font-weight:600;">
                                {{ $student->full_name }}
                            </td>

                            <td style="padding:12px;">
                                <span
                                    style="padding:4px 10px; border-radius:999px; background:#e0f2fe; color:#0369a1; font-size:11px;">
                                    {{ $student->level->slug ?? '-' }}
                                </span>
                            </td>

                            <td style="padding:12px;">
                                {{ $student->programme->name ?? '-' }}
                            </td>

                            <td style="padding:12px;">
                                {{ $student->courseOption->code ?? 'N/A' }}
                            </td>

                            <td style="padding:12px; font-family:monospace;">
                                {{ $student->matric_number ?? '-' }}
                            </td>

                            <td style="padding:12px; text-align:right;">
                                <a href="{{ route('edit-student', $student->id) }}"
                                    style="display:inline-flex; align-items:center; gap:6px; padding:6px 10px;
                  border-radius:8px; border:1px solid #e4e4e7; background:white;
                  font-size:12px; text-decoration:none; color:#111827;">
                                    ✏ Edit
                                </a>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" style="padding:20px; text-align:center; color:#9ca3af;">
                                No students found.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>

        </div>

        {{-- PAGINATION --}}
        <div
            style="
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-top:16px;
            padding-top:14px;
            border-top:1px solid #e4e4e7;
            font-size:13px;
            color:#71717a;
            font-family: system-ui, -apple-system, sans-serif;
        ">

            {{-- Target Wrapper to cleanly box Livewire's native async buttons --}}
            <div class="custom-pagination-container" style="max-width: 100%;">
                {{ $students->links(data: ['scrollTo' => false]) }}
            </div>

        </div>

    </flux:card>

</div>
