<div>
    <flux:card class="bg-zinc-50/80 dark:bg-zinc-900/50 border-zinc-200/60 shadow-sm">
        <div class="flex items-center gap-2 mb-6">
            <flux:icon name="academic-cap" variant="outline" class="text-zinc-400" />
            <flux:heading size="lg">Create and Manage Level</flux:heading>
        </div>

        <div
            class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end mb-8 bg-white/50 dark:bg-white/[0.02] p-4 rounded-xl border border-zinc-200/50">
            <flux:input wire:model.live="name" label="Level Name" placeholder="National Diploma 1" />

            <flux:input wire:model.live="slug" label="Abbreviation" placeholder="ND1" />

            <flux:button wire:click="createLevel" variant="primary" icon="plus" class="w-full">
                Create Level
            </flux:button>
        </div>

        <flux:table>
            <flux:table.columns>
                <flux:table.column align="center">Level Name</flux:table.column>
                <flux:table.column align="center">Slug</flux:table.column>
                <flux:table.column align="center">Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse($levels as $level)
                    <flux:table.row>
                        <flux:table.cell align="center" class="font-medium">
                            {{ $level->name }}
                        </flux:table.cell>

                        <flux:table.cell align="center">
                            <flux:badge color="zinc">
                                {{ $level->slug }}
                            </flux:badge>
                        </flux:table.cell>

                        <flux:table.cell align="center">
                            <flux:modal.trigger name="edit-level">
                                <flux:button wire:click="edit({{ $level->id }})" variant="ghost" size="sm"
                                    icon="pencil-square">
                                    Edit
                                </flux:button>
                            </flux:modal.trigger>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="3" align="center">
                            No levels found.
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>

    {{-- Modal Card --}}
    <flux:modal name="edit-level" class="md:w-[500px] space-y-6">
        <div>
            <flux:heading size="lg">Edit Level Details</flux:heading>
            <flux:subheading>Update the naming convention for this level.</flux:subheading>
        </div>

        <div class="space-y-4">
            <flux:input wire:model="editName" label="Level Name" />

            <flux:input wire:model="editSlug" label="Slug" />
        </div>

        <div class="flex flex-col-reverse md:flex-row justify-between gap-3 mt-6">
            <flux:button wire:click="deleteLevel" variant="ghost" icon="trash"
                style="color:#dc2626;border:1px dashed #dc2626;">
                Delete Level
            </flux:button>

            <div class="flex gap-2">
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" wire:click="updateLevel">Save Changes</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
