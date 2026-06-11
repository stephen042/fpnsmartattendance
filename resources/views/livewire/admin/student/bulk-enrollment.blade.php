<div class="space-y-8">

    {{-- Upload --}}
    <div wire:loading.class="opacity-60 pointer-events-none">

        <flux:card class="bg-zinc-50 dark:bg-white/5 border-dashed border-2 relative">

            <div class="space-y-4">

                <div>
                    <flux:heading size="lg">Bulk Enrollment</flux:heading>
                    <flux:subheading>
                        Upload a CSV file with student data.
                    </flux:subheading>
                </div>

                <div
                    class="group relative flex flex-col items-center justify-center p-6 border-2 border-dashed rounded-xl cursor-pointer">

                    <flux:icon name="document-arrow-up" class="mb-2 text-zinc-400 group-hover:text-blue-500" />

                    <span class="text-xs text-zinc-500 text-center">
                        Drag and drop file or click to browse
                    </span>

                    <input type="file" wire:model="file" class="absolute inset-0 opacity-0 cursor-pointer">
                </div>
                @if (session('success'))
                    <div class="text-green-600 text-sm">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            {{-- LOADING OVERLAY --}}
            <div wire:loading wire:target="file"
                class="absolute inset-0 flex items-center justify-center bg-white/60 dark:bg-black/40 backdrop-blur-sm rounded-xl">

                <div class="flex flex-col items-center gap-2">

                    <div class="w-10 h-10 border-4 border-blue-500 border-t-transparent rounded-full animate-spin">
                    </div>

                    <p style="animation: fadeIn 1s ease-in-out infinite alternate; color: #3b82f6; font-weight: 500;">
                        Processing CSV...
                    </p>

                </div>

            </div>

        </flux:card>

    </div>


    {{-- Review Queue --}}
    @if (count($rows))

        <flux:card class="p-0 overflow-hidden">

            <div class="p-6 flex justify-between items-center border-b">

                <div>
                    <flux:heading size="lg">
                        Review Enrollment Queue
                    </flux:heading>

                    <flux:subheading>
                        Review and correct student data before finalizing.
                    </flux:subheading>
                </div>

                @if (session('error'))
                    <div class="text-red-600 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <flux:button wire:click="finalize" variant="primary" icon="user-plus">
                    Finalize & Enroll Students
                </flux:button>

            </div>

            <div style="width:100%; overflow-x:auto; border:1px solid #e4e4e7; border-radius:12px;">

                <div style="min-width:1500px;">

                    <table style="width:100%; border-collapse:collapse; font-size:13px;">

                        {{-- HEADER --}}
                        <thead
                            style="position:sticky; top:0; background:#f4f4f5; z-index:10; border-bottom:1px solid #e4e4e7;">
                            <tr
                                style="text-align:left; font-size:11px; letter-spacing:0.05em; text-transform:uppercase; color:#71717a;">

                                <th style="padding:14px; width:280px;">App No</th>
                                <th style="padding:14px; width:180px;">Matric No</th>
                                <th style="padding:14px; width:260px;">Full Name</th>
                                <th style="padding:14px; width:220px;">Email</th>
                                <th style="padding:14px; width:180px;">Phone</th>
                                <th style="padding:14px; width:120px;">Gender</th>
                                <th style="padding:14px; width:220px;">Department</th>
                                <th style="padding:14px; width:220px;">Course Option</th>
                                <th style="padding:14px; width:160px;">Level</th>
                                <th style="padding:14px; width:220px;">Programme</th>
                                <th style="padding:14px; width:120px; text-align:center;">Action</th>

                            </tr>
                        </thead>

                        {{-- BODY --}}
                        <tbody>

                            @foreach ($this->paginatedRows as $index => $row)
                                <tr style="border-bottom:1px solid #f1f5f9; transition:0.2s;">

                                    <td style="padding:10px; width:280px;">
                                        <input
                                            wire:model="rows.{{ ($page - 1) * $perPage + $index }}.application_number"
                                            style="width:100%; padding:10px; border:1px solid #84b1f9; border-radius:8px; background:transparent;"
                                            onfocus="this.style.border='1px solid #3b82f6'; this.style.background='#f8fafc'"
                                            onblur="this.style.border='1px solid transparent'; this.style.background='transparent'">
                                    </td>

                                    <td style="padding:10px; width:180px;">
                                        <input wire:model="rows.{{ ($page - 1) * $perPage + $index }}.matric_number"
                                            style="width:100%; padding:10px; border:1px solid #84b1f9; border-radius:8px; background:transparent;"
                                            onfocus="this.style.border='1px solid #3b82f6'; this.style.background='#f8fafc'"
                                            onblur="this.style.border='1px solid transparent'; this.style.background='transparent'">
                                    </td>

                                    <td style="padding:10px; width:260px;">
                                        <input wire:model="rows.{{ ($page - 1) * $perPage + $index }}.full_name"
                                            style="width:100%; padding:10px; border:1px solid #84b1f9; border-radius:8px; background:transparent; font-weight:600;"
                                            onfocus="this.style.border='1px solid #3b82f6'; this.style.background='#f8fafc'"
                                            onblur="this.style.border='1px solid transparent'; this.style.background='transparent'">
                                    </td>

                                    <td style="padding:10px; width:220px;">
                                        <input wire:model="rows.{{ ($page - 1) * $perPage + $index }}.email"
                                            style="width:100%; padding:10px; border:1px solid #84b1f9; border-radius:8px; background:transparent;"
                                            onfocus="this.style.border='1px solid #3b82f6'; this.style.background='#f8fafc'"
                                            onblur="this.style.border='1px solid transparent'; this.style.background='transparent'">
                                    </td>

                                    <td style="padding:10px; width:180px;">
                                        <input wire:model="rows.{{ ($page - 1) * $perPage + $index }}.phone"
                                            style="width:100%; padding:10px; border:1px solid #84b1f9; border-radius:8px; background:transparent;"
                                            onfocus="this.style.border='1px solid #3b82f6'; this.style.background='#f8fafc'"
                                            onblur="this.style.border='1px solid transparent'; this.style.background='transparent'">
                                    </td>

                                    <td style="padding:10px; width:120px;">
                                        <select wire:model="rows.{{ ($page - 1) * $perPage + $index }}.gender"
                                            style="width:100%; padding:10px; border:1px solid #84b1f9; border-radius:8px; background:transparent; cursor:pointer;">
                                            <option value="">--</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </td>

                                    <td style="padding:10px; width:220px;">
                                        <input wire:model="rows.{{ ($page - 1) * $perPage + $index }}.department"
                                            style="width:100%; padding:10px; border:1px solid #84b1f9; border-radius:8px; background:transparent;"
                                            onfocus="this.style.border='1px solid #3b82f6'; this.style.background='#f8fafc'"
                                            onblur="this.style.border='1px solid transparent'; this.style.background='transparent'">
                                    </td>

                                    <td style="padding:10px; width:220px;">
                                        <input wire:model="rows.{{ ($page - 1) * $perPage + $index }}.course_option"
                                            style="width:100%; padding:10px; border:1px solid #84b1f9; border-radius:8px; background:transparent;"
                                            onfocus="this.style.border='1px solid #3b82f6'; this.style.background='#f8fafc'"
                                            onblur="this.style.border='1px solid transparent'; this.style.background='transparent'">
                                    </td>

                                    <td style="padding:10px; width:160px;">
                                        <input wire:model="rows.{{ ($page - 1) * $perPage + $index }}.level"
                                            style="width:100%; padding:10px; border:1px solid #84b1f9; border-radius:8px; background:transparent;"
                                            onfocus="this.style.border='1px solid #3b82f6'; this.style.background='#f8fafc'"
                                            onblur="this.style.border='1px solid transparent'; this.style.background='transparent'">
                                    </td>

                                    <td style="padding:10px; width:220px;">
                                        <input wire:model="rows.{{ ($page - 1) * $perPage + $index }}.programme"
                                            style="width:100%; padding:10px; border:1px solid #84b1f9; border-radius:8px; background:transparent;"
                                            onfocus="this.style.border='1px solid #3b82f6'; this.style.background='#f8fafc'"
                                            onblur="this.style.border='1px solid transparent'; this.style.background='transparent'">
                                    </td>

                                    <td style="padding:10px; width:120px; text-align:center;">
                                        <button wire:click="removeRow({{ ($page - 1) * $perPage + $index }})"
                                            style="padding:8px 10px; border-radius:8px; border:1px solid #fecaca; background:#fff1f2; color:#ef4444; cursor:pointer;">
                                            ✕
                                        </button>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                    {{-- PAGINATION --}}
                    <div
                        style="
                        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
                        display: block;
                        align-items: center;
                        padding: 12px 24px;
                        border: 1px solid #e4e4e7;
                        border-radius: 0 0 12px 12px;
                        background: #ffffff;
                        font-size: 14px;
                        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
                    ">
                        <div style="color: #71717a; font-weight: 400; margin: 10px 0;">
                            Showing
                            <span style="color: #18181b; font-weight: 600;">{{ ($page - 1) * $perPage + 1 }}</span>
                            to
                            <span
                                style="color: #18181b; font-weight: 600;">{{ min($page * $perPage, count($rows)) }}</span>
                            of
                            <span style="color: #18181b; font-weight: 600;">{{ count($rows) }}</span>
                            results
                        </div>

                        <div style="display: flex; gap: 10px;">

                            <button wire:click="$set('page', {{ max(1, $page - 1) }})"
                                @if ($page <= 1) disabled @endif
                                style="
                                padding: 8px 14px;
                                border: 1px solid #e4e4e7;
                                background: white;
                                color: #27272a;
                                border-radius: 6px;
                                font-weight: 500;
                                font-size: 13px;
                                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
                                display: inline-flex;
                                align-items: center;
                                gap: 6px;
                                user-select: none;
                                transition: background-color 0.15s ease;
                                {{ $page <= 1 ? 'opacity: 0.5; cursor: not-allowed; background: #f4f4f5; color: #a1a1aa;' : 'cursor: pointer;' }}
                            ">
                                <span style="font-size: 14px; line-height: 1;">&larr;</span> Previous
                            </button>

                            <button wire:click="$set('page', {{ $page + 1 }})"
                                @if ($page * $perPage >= count($rows)) disabled @endif
                                style="
                                padding: 8px 14px;
                                border: 1px solid #e4e4e7;
                                background: white;
                                color: #27272a;
                                border-radius: 6px;
                                font-weight: 500;
                                font-size: 13px;
                                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
                                display: inline-flex;
                                align-items: center;
                                gap: 6px;
                                user-select: none;
                                transition: background-color 0.15s ease;
                                {{ $page * $perPage >= count($rows) ? 'opacity: 0.5; cursor: not-allowed; background: #f4f4f5; color: #a1a1aa;' : 'cursor: pointer;' }}
                            ">
                                Next <span style="font-size: 14px; line-height: 1;">&rarr;</span>
                            </button>

                        </div>
                    </div>

                </div>

            </div>

        </flux:card>

    @endif

</div>
