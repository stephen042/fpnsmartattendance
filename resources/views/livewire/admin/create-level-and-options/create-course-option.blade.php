<div>
    <flux:card class="bg-zinc-50/80 dark:bg-zinc-900/50 border-zinc-200/60 shadow-sm mt-8">
        <div class="flex items-center gap-2 mb-6">
            <flux:icon name="book-open" variant="outline" class="text-zinc-400" />
            <flux:heading size="lg">Create and Manage Course Option</flux:heading>
        </div>

        <div
            class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end mb-8 bg-white/50 dark:bg-white/[0.02] p-4 rounded-xl border border-zinc-200/50">
            <flux:select wire:model="level_id" label="Select Level" placeholder="Choose Level...">
                @foreach ($levels as $level)
                    <flux:select.option value="{{ $level->id }}">
                        {{ $level->slug }}
                    </flux:select.option>
                @endforeach
            </flux:select>

            <flux:input wire:model="name" label="Option Name" placeholder="Software And Web Development" />

            <flux:input wire:model="code" label="Option Abbreviation" placeholder="SWD" />

            <flux:button wire:click="createOption" variant="primary" icon="plus" class="w-full">
                Create Option
            </flux:button>
        </div>

        <flux:table>
            <flux:table.columns>
                <flux:table.column>Level</flux:table.column>
                <flux:table.column>Option Name</flux:table.column>
                <flux:table.column align="center">Abbreviation</flux:table.column>
                <flux:table.column align="center">Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse($options as $option)
                    <flux:table.row>
                        <flux:table.cell>
                            {{ $option->level->slug ?? "N/A" }}
                        </flux:table.cell>

                        <flux:table.cell class="font-medium">
                            {{ $option->name }}
                        </flux:table.cell>

                        <flux:table.cell align="center">
                            <flux:badge color="zinc">
                                {{ $option->code }}
                            </flux:badge>
                        </flux:table.cell>

                        <flux:table.cell align="center">
                            <flux:modal.trigger name="edit-course-option">
                                <flux:button wire:click="edit({{ $option->id }})" variant="ghost" size="sm"
                                    icon="pencil-square">
                                    Edit
                                </flux:button>
                            </flux:modal.trigger>

                            <flux:button wire:click="deleteOption({{ $option->id }})" variant="ghost" size="sm"
                                icon="trash" style="color:#dc2626;border:1px dashed #dc2626;">
                            </flux:button>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="4" align="center">
                            No course options found.
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>

    {{-- Edit Course Option Modal --}}
    <flux:modal name="edit-course-option" class="md:w-[500px] space-y-6">

        <div class="space-y-4">

            <flux:select wire:model="editLevelId" label="Level">
                @foreach ($levels as $level)
                    <flux:select.option value="{{ $level->id }}">
                        {{ $level->name }}
                    </flux:select.option>
                @endforeach
            </flux:select>

            <flux:input wire:model="editName" label="Option Name" />
            <flux:input wire:model="editCode" label="Option Abbreviation" />
        </div>

        <div class="flex flex-col-reverse md:flex-row justify-between gap-3 mt-6">

            <flux:button wire:click="deleteOption({{ $editId }})" variant="ghost" icon="trash"
                style="color:#dc2626;border:1px dashed #dc2626;">
                Delete Option
            </flux:button>

            <div class="flex gap-2">
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>

                <flux:button wire:click="updateOption" variant="primary">
                    Save Changes
                </flux:button>
            </div>
        </div>

    </flux:modal>
</div>
