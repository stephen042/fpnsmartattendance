<div>
    <flux:card class="bg-zinc-50/80 dark:bg-zinc-900/50 border-zinc-200/60 shadow-sm">

        <div class="flex items-center gap-2 mb-6">
            <flux:icon name="clock" variant="outline" class="text-zinc-400" />
            <flux:heading size="lg">Create And Manage Programme</flux:heading>
        </div>

        {{-- CREATE --}}
        <div
            class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end mb-8 bg-white/50 dark:bg-white/[0.02] p-4 rounded-xl border border-zinc-200/50">

            <flux:input wire:model="name" label="Programme Name" placeholder="e.g. Morning, Evening" />
            @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror

            <flux:button wire:click="createProgramme" variant="primary" icon="plus">
                Create Programme
            </flux:button>
        </div>

        {{-- TABLE --}}
        <flux:table>
            <flux:table.columns>
                <flux:table.column align="center">Programme Name</flux:table.column>
                <flux:table.column align="center">Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse($programmes as $programme)
                    <flux:table.row>
                        <flux:table.cell align="center" class="font-medium">
                            {{ $programme->name }}
                        </flux:table.cell>

                        <flux:table.cell align="center">
                            <flux:button wire:click="deleteProgramme({{ $programme->id }})" variant="ghost"
                                size="sm" icon="trash" style="color: #dc2626;border: 1px dashed #dc2626;">
                                Delete
                            </flux:button>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="2" align="center">
                            No programmes found.
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

    </flux:card>
</div>
