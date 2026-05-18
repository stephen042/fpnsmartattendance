<x-layouts::app :title="__('Update Lecturers')">
    <div class="max-w-6xl mx-auto space-y-8 pb-12">

        {{-- Header Section --}}
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">Update Lecturers</flux:heading>
                <flux:subheading>Update Deparment Lecturers Details</flux:subheading>
            </div>
        </div>

        <flux:card class="bg-zinc-50/80 dark:bg-zinc-900/50 border-zinc-200/60 shadow-sm">
            <div class="flex items-center gap-2 mb-6">
                <flux:icon name="user-group" variant="outline" class="text-zinc-400" />
                <flux:heading size="lg">Update Lecturer Details</flux:heading>
            </div>

            {{-- Registration Form --}}
            <div class="max-w-3xl">
                <div
                    class="space-y-8 bg-white/50 dark:bg-white/[0.02] p-8 rounded-2xl border border-zinc-200/50 shadow-sm">

                    {{-- Section 1: Basic Information --}}
                    <section class="space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-1 bg-blue-500 rounded-full"></div>
                            <flux:heading size="lg">Basic Information</flux:heading>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-6 gap-6">
                            <div class="md:col-span-2">
                                <flux:select label="Title" placeholder="Choose Title">
                                    <flux:select.option selected>Prof.</flux:select.option>
                                    <flux:select.option>Dr.</flux:select.option>
                                    <flux:select.option>Mr.</flux:select.option>
                                    <flux:select.option>Ms.</flux:select.option>
                                    <flux:select.option>Engr.</flux:select.option>
                                </flux:select>
                            </div>

                            <div class="md:col-span-4">
                                <flux:input label="Full Name" placeholder="e.g. John Makuochukwu Doe" value="IBE IJEOMA UGOCHUKWU" />
                            </div>

                            <div class="md:col-span-3">
                                <flux:select label="Gender" placeholder="Select Gender">
                                    <flux:select.option>Male</flux:select.option>
                                    <flux:select.option selected>Female</flux:select.option>
                                </flux:select>
                            </div>

                            <div class="md:col-span-3">
                                <flux:input label="Phone Number" placeholder="09087..." icon="phone" value="09087654321" />
                            </div>

                            <div class="md:col-span-6">
                                <flux:input label="Staff ID" placeholder="FPNO/HNDE/2024/..." icon="identification" value="FPNO/STAFF/2001/009" />
                            </div>
                        </div>
                    </section>

                    {{-- Submission Area --}}
                    <div class="pt-4 flex justify-end gap-3">
                        <flux:button variant="ghost" onclick="window.history.back()">Cancel</flux:button>
                        <flux:button variant="primary" icon="user-plus" class="px-8">
                            Update Lecturer's Details
                        </flux:button>
                    </div>
                </div>
            </div>
        </flux:card>
    </div>
</x-layouts::app>
