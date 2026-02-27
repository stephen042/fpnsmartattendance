<x-layouts::app :title="__('Create Level')">
    <div class="max-w-5xl mx-auto space-y-8 pb-12">

        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">Academic Configuration</flux:heading>
                <flux:subheading>Manage school levels and study programmes.</flux:subheading>
            </div>
        </div>

        {{-- Level Card --}}
        <flux:card class="bg-zinc-50/80 dark:bg-zinc-900/50 border-zinc-200/60 shadow-sm">
            <div class="flex items-center gap-2 mb-6">
                <flux:icon name="academic-cap" variant="outline" class="text-zinc-400" />
                <flux:heading size="lg">Level Management</flux:heading>
            </div>

            <div
                class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end mb-8 bg-white/50 dark:bg-white/[0.02] p-4 rounded-xl border border-zinc-200/50">
                <flux:input label="Level Name" placeholder="National Diploma 1" />
                <flux:input label="Abbreviation" placeholder="ND1" />
                <flux:button variant="primary" icon="plus" class="w-full">Create Level</flux:button>
            </div>

            <flux:table>
                <flux:table.columns>
                    <flux:table.column align="center">Level Name</flux:table.column>
                    <flux:table.column align="center">Abbreviation</flux:table.column>
                    <flux:table.column align="center">Action</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    <flux:table.row>
                        <flux:table.cell align="center" class="font-medium">National Diploma 1</flux:table.cell>
                        <flux:table.cell align="center">
                            <flux:badge color="zinc">ND1</flux:badge>
                        </flux:table.cell>
                        <flux:table.cell align="center">
                            <flux:modal.trigger name="edit-level">
                                <flux:button variant="ghost" size="sm" icon="pencil-square">
                                    Edit
                                </flux:button>
                            </flux:modal.trigger>
                        </flux:table.cell>
                    </flux:table.row>
                </flux:table.rows>
            </flux:table>
        </flux:card>


        {{-- Programme Card --}}
        <flux:card class="bg-zinc-50/80 dark:bg-zinc-900/50 border-zinc-200/60 shadow-sm">
            <div class="flex items-center gap-2 mb-6">
                <flux:icon name="clock" variant="outline" class="text-zinc-400" />
                <flux:heading size="lg">Programme Management</flux:heading>
            </div>

            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end mb-8 bg-white/50 dark:bg-white/[0.02] p-4 rounded-xl border border-zinc-200/50">
                <flux:input label="Programme Name" placeholder="e.g. Morning, Evening" />
                <flux:button variant="primary" icon="plus">Create Programme</flux:button>
            </div>

            <flux:table>
                <flux:table.columns>
                    <flux:table.column align="center">Programme Name</flux:table.column>
                    <flux:table.column align="center">Action</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    <flux:table.row>
                        <flux:table.cell align="center" class="font-medium">Morning</flux:table.cell>
                        <flux:table.cell align="center">
                            <flux:button variant="ghost" size="sm" icon="trash" style="color: #dc2626;border: 1px dashed #dc2626;">Delete
                            </flux:button>
                        </flux:table.cell>
                    </flux:table.row>
                </flux:table.rows>
            </flux:table>
        </flux:card>
    </div>

    {{-- Modal Card --}}
    <flux:modal name="edit-level" class="md:w-[500px] space-y-6">
        <div>
            <flux:heading size="lg">Edit Level Details</flux:heading>
            <flux:subheading>Update the naming convention for this level.</flux:subheading>
        </div>

        <div class="space-y-4">
            <flux:input label="Level Name" value="National Diploma 1"/>
            <flux:input label="Abbreviation" value="ND1" />
        </div>

        <div class="flex flex-col-reverse md:flex-row justify-between gap-3 mt-6">
            <flux:button variant="ghost" icon="trash" style="color: #dc2626;border: 1px dashed #dc2626;">
                Delete Level
            </flux:button>

            <div class="flex gap-2">
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary">Save Changes</flux:button>
            </div>
        </div>
    </flux:modal>
</x-layouts::app>
