<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-neutral-100 antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
    <div class="bg-muted flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
        <div class="flex w-full max-w-md flex-col gap-6">
            <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                <img src="{{ asset('assets/images/logo/logo.png') }}" alt="site logo" width="150" height="100" />

                <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
            </a>

            <livewire:student.student-login />
        </div>
    </div>
    @fluxScripts
</body>

</html>
