<div>
    <div class="max-w-3xl">
        <div class="space-y-8 bg-white/50 dark:bg-white/[0.02] p-8 rounded-2xl border border-zinc-200/50 shadow-sm">

            <section class="space-y-6">
                <div class="flex items-center gap-3">
                    <div class="h-8 w-1 bg-blue-500 rounded-full"></div>
                    <flux:heading size="lg">Basic Information</flux:heading>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-6 gap-6">

                    <div class="md:col-span-2">
                        <flux:select wire:model="title" label="Title">

                            <flux:select.option value="Prof.">Prof.</flux:select.option>
                            <flux:select.option value="Dr.">Dr.</flux:select.option>
                            <flux:select.option value="Mr.">Mr.</flux:select.option>
                            <flux:select.option value="Ms.">Ms.</flux:select.option>
                            <flux:select.option value="Engr.">Engr.</flux:select.option>

                        </flux:select>
                    </div>

                    <div class="md:col-span-4">
                        <flux:input wire:model="full_name" label="Full Name" />
                    </div>

                    <div class="md:col-span-3">
                        <flux:select wire:model="gender" label="Gender">

                            <flux:select.option value="male">
                                Male
                            </flux:select.option>

                            <flux:select.option value="female">
                                Female
                            </flux:select.option>

                        </flux:select>
                    </div>

                    <div class="md:col-span-3">
                        <flux:input wire:model="phone_number" label="Phone Number" icon="phone" />
                    </div>

                    <div class="md:col-span-6">
                        <flux:input wire:model="staff_id" label="Staff ID" icon="identification" />
                    </div>

                </div>
            </section>

            <div class="pt-4 flex justify-end">
                <div>
                    <div class="flex gap-3">
                        <flux:button variant="ghost" onclick="window.history.back()">
                            Cancel
                        </flux:button>

                        <flux:button wire:click="updateLecturer" variant="primary" icon="check">
                            Update Lecturer's Details
                        </flux:button>
                    </div>

                    @if (session()->has('success'))
                        <div class="mt-2 text-sm text-green-600 dark:text-green-400">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
