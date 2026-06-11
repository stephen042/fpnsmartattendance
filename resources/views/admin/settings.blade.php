<x-layouts::app :title="__('Application Settings')">
    <div class="max-w-4xl mx-auto space-y-8 pb-12">

        <div>
            <flux:heading size="xl">Global Application Settings</flux:heading>
            <flux:subheading>Configure system-wide academic variables, network firewalls, and institutional faculty
                definitions independently.</flux:subheading>
        </div>

        <form wire:submit="saveAcademicContext" class="block">
            <flux:card class="space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <flux:heading size="lg">Current Academic Context</flux:heading>
                        <flux:subheading>Define the system-wide active parameters for general operations.
                        </flux:subheading>
                    </div>
                    <flux:button type="submit" variant="primary" icon="check" size="sm" class="sm:px-4 shrink-0">
                        Update
                    </flux:button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                    <flux:select label="Active Academic Session *" placeholder="Select active session...">
                        <option value="2024/2025" selected>2024/2025 Academic Session</option>
                        <option value="2025/2026">2025/2026 Academic Session</option>
                        <option value="2026/2027">2026/2027 Academic Session</option>
                    </flux:select>

                    <flux:select label="Active Semester *" placeholder="Select active semester...">
                        <option value="First" selected>First Semester</option>
                        <option value="Second">Second Semester</option>
                    </flux:select>
                </div>
            </flux:card>
        </form>


        <form wire:submit="saveNetworkConfig" class="block">
            <flux:card class="space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <flux:switch name="restrict_ip" checked class="mt-1" />
                        <div>
                            <flux:heading size="lg">Network & IP Restrictions</flux:heading>
                            <flux:subheading>Restrict student sign-ins or session management to specific institutional
                                networks.</flux:subheading>
                        </div>
                    </div>
                    <flux:button type="submit" variant="primary" icon="check" size="sm"
                        class="sm:px-4 shrink-0 self-end sm:self-start">
                        Save Firewall
                    </flux:button>
                </div>

                <div class="space-y-4 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                            Allowed IP Ranges / Subnet Patterns
                        </label>
                        <flux:subheading class="mb-2 block">Define regular expressions or explicit CIDR/wildcard ranges
                            block by block.</flux:subheading>

                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <flux:input class="flex-1 font-mono" value="192.168.1.*"
                                    placeholder="e.g. 10.0.0.* or 192.168.1.50" />
                                <flux:button variant="ghost" color="red" icon="trash" size="sm" />
                            </div>
                        </div>

                        <div class="pt-2">
                            <flux:button variant="ghost" icon="plus" size="sm"
                                class="text-zinc-600 dark:text-zinc-400">
                                Add Network Subnet Pattern
                            </flux:button>
                        </div>
                    </div>
                </div>
            </flux:card>
        </form>


        <form wire:submit="saveDepartments" class="block">
            <flux:card class="space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <flux:heading size="lg">Academic Departments Registry</flux:heading>
                        <flux:subheading>Manage available departments and their short identifiers across registration
                            modules.</flux:subheading>
                    </div>
                    <flux:button type="submit" variant="primary" icon="check" size="sm"
                        class="sm:px-4 shrink-0">
                        Save Registry
                    </flux:button>
                </div>

                <div class="space-y-3 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                    <div
                        class="hidden md:grid grid-cols-12 gap-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider px-2">
                        <div class="col-span-7">Department Name</div>
                        <div class="col-span-4">System Code</div>
                        <div class="col-span-1 text-center">Actions</div>
                    </div>

                    <div
                        class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center bg-zinc-50 dark:bg-white/5 p-3 rounded-xl md:bg-transparent md:p-0">
                        <div class="col-span-1 md:col-span-7">
                            <label class="text-xs font-bold text-zinc-500 block md:hidden mb-1">Department Name</label>
                            <flux:input value="Computer Science" placeholder="e.g. Computer Science" />
                        </div>
                        <div class="col-span-1 md:col-span-4">
                            <label class="text-xs font-bold text-zinc-500 block md:hidden mb-1">System Code</label>
                            <flux:input class="font-mono uppercase" value="CSC" placeholder="e.g. CSC" />
                        </div>
                        <div class="col-span-1 md:col-span-1 flex justify-end md:justify-center pt-2 md:pt-0">
                            <flux:button variant="ghost" color="red" icon="trash" size="sm" />
                        </div>
                    </div>

                    <div
                        class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center bg-zinc-50 dark:bg-white/5 p-3 rounded-xl md:bg-transparent md:p-0">
                        <div class="col-span-1 md:col-span-7">
                            <label class="text-xs font-bold text-zinc-500 block md:hidden mb-1">Department Name</label>
                            <flux:input value="Statistics" placeholder="e.g. Statistics" />
                        </div>
                        <div class="col-span-1 md:col-span-4">
                            <label class="text-xs font-bold text-zinc-500 block md:hidden mb-1">System Code</label>
                            <flux:input class="font-mono uppercase" value="STA" placeholder="e.g. STA" />
                        </div>
                        <div class="col-span-1 md:col-span-1 flex justify-end md:justify-center pt-2 md:pt-0">
                            <flux:button variant="ghost" color="red" icon="trash" size="sm" />
                        </div>
                    </div>

                    <div class="pt-2 flex justify-between items-center">
                        <flux:button variant="ghost" icon="plus" size="sm"
                            class="text-zinc-600 dark:text-zinc-400">
                            Append New Department Node
                        </flux:button>
                    </div>
                </div>
            </flux:card>
        </form>

    </div>
</x-layouts::app>
