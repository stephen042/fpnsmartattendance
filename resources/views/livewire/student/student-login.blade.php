<div>
    <div class="flex flex-col gap-6">
        <div class="rounded-xl border bg-white dark:bg-stone-950 dark:border-stone-800 shadow-xs">
            <div class="px-10 py-8">

                <x-auth-header :title="__('Log in to your Student Account')" :description="__('Enter your Application Number below to log in')" />

                <x-auth-session-status class="text-center" :status="session('error')" />

                <form wire:submit.prevent="login" class="flex flex-col gap-6 mt-4">

                    <flux:input wire:model="application_number" name="application_number" label="APP NO" type="text"
                        required autofocus placeholder="e.g FPN/HNDM/2024/00001" />

                    <div class="flex items-center justify-end">

                        <flux:button type="submit" class="w-full" wire:loading.attr="disabled" wire:target="login"

                            x-bind:disabled="!$wire.device_ready">login</flux:button>

                    </div>

                    <!-- Inside your form, above the button -->
                    @if (!$device_ready)
                        <div class="text-xs text-gray-500">Securing device...</div>
                    @endif
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@fingerprintjs/fingerprintjs@3/dist/fp.min.js"></script>

    <script>
        document.addEventListener('livewire:navigated', initFingerprint);
        document.addEventListener('livewire:load', initFingerprint);

        function initFingerprint() {
            console.log('Fingerprint init running...');

            const component = Livewire.first();
            if (!component) return;

            if (typeof FingerprintJS === 'undefined') {
                console.error('FingerprintJS not loaded');
                return;
            }

            FingerprintJS.load().then(fp => {
                fp.get().then(result => {
                    console.log('Fingerprint generated:', result.visitorId);

                    function generateUUID() {
                        if (window.crypto && crypto.randomUUID) {
                            return crypto.randomUUID();
                        }
                        return 'xxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                            let r = Math.random() * 16 | 0;
                            let v = c === 'x' ? r : (r & 0x3 | 0x8);
                            return v.toString(16);
                        });
                    }

                    let localToken = localStorage.getItem('device_token') || generateUUID();
                    localStorage.setItem('device_token', localToken);

                    component.call('setDeviceData', {
                        device_hash: result.visitorId,
                        device_local_token: localToken,
                        device_screen_hash: btoa(window.screen.width + 'x' + window.screen.height),
                        device_user_agent: navigator.userAgent
                    });
                });
            });
        }
    </script>
</div>
