<div>
    @props(['type' => 'info'])

    @php
        $styles =
            [
                'success' => 'bg-green-500 text-white',
                'error' => 'bg-red-500 text-white',
                'info' => 'bg-blue-500 text-white',
            ][$type] ?? 'bg-gray-800 text-white';

        $message = session($type);
    @endphp

    @if ($message)
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 6000)" x-show="show" x-transition
            class="fixed top-5 right-5 z-50 px-4 py-3 rounded-lg shadow-lg {{ $styles }}">
            {{ $message }}
        </div>
    @endif
</div>
