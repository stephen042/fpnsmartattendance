<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="xl">
                Attendance History
            </flux:heading>

            <flux:subheading>
                {{ $student->full_name }} • {{ $student->matric_number }}
            </flux:subheading>
        </div>

        <flux:badge color="zinc">
            Total Records: {{ $records->count() }}
        </flux:badge>
    </div>

    {{-- TABLE --}}
    <flux:card class="overflow-hidden">

        <flux:table>
            <flux:table.columns>
                <flux:table.column>Date</flux:table.column>
                <flux:table.column>Full Name</flux:table.column>
                <flux:table.column>Level</flux:table.column>
                <flux:table.column>Programme</flux:table.column>
                <flux:table.column>Course Option</flux:table.column>
                <flux:table.column>App No</flux:table.column>
                <flux:table.column>MAT No</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column>Device Fingerprint</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($records as $record)
                    <flux:table.row>

                        <flux:table.cell>
                            {{ $record->signed_in_at->format('d M Y H:i') }}
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ $record->full_name }}
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ $record->level_name }}
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ $record->programme_name }}
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ $record->course_option_name }}
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ $record->application_number }}
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ $record->matric_number }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:badge
                                color="{{ $record->status === 'present' ? 'green' : ($record->status === 'absent' ? 'red' : 'yellow') }}">
                                {{ ucfirst($record->status) }}
                            </flux:badge>
                        </flux:table.cell>

                        <flux:table.cell>
                            <span class="text-xs text-zinc-500">
                                {{ $record->device_hash }}
                            </span>
                        </flux:table.cell>

                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>

    </flux:card>

</div>
