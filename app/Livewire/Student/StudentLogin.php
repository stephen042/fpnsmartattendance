<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Student;
use App\Models\Settings;

class StudentLogin extends Component
{
    public string $application_number = '';
    public string $device_hash = '';
    public string $device_user_agent = '';
    public string $device_screen_hash = '';
    public string $device_local_token = '';
    public bool $device_ready = false;

    public function mount()
    {
        $this->device_user_agent = request()->userAgent() ?? '';
        $this->device_ready = false;
    }

    // IP pattern matcher helper
    protected function ipMatches(string $ip, array $patterns): bool
    {
        foreach ($patterns as $pattern) {
            $pattern = str_replace('.', '\.', $pattern);
            $pattern = str_replace('*', '.*', $pattern);

            if (preg_match('/^' . $pattern . '$/', $ip)) {
                return true;
            }
        }

        return false;
    }

    // Receive device fingerprint data from frontend
    public function setDeviceData(array $data)
    {
        logger('Device data received', $data);

        $this->device_hash = $data['device_hash'] ?? '';
        $this->device_screen_hash = $data['device_screen_hash'] ?? '';
        $this->device_local_token = $data['device_local_token'] ?? '';
        $this->device_user_agent = $data['device_user_agent'] ?? '';

        $this->device_ready = true;
    }

    // Handle student login
    public function login()
    {
        $this->validate([
            'application_number' => 'required|string'
        ]);

        // Find student by application number
        $student = Student::where('application_number', $this->application_number)
            ->where('is_active', true)
            ->first();

        if (!$student) {
            session()->flash('error', 'Invalid Application Number');
            return;
        }

        // Load system settings
        $settings = Settings::first();
        $ipConfig = $settings->ip_config ?? [];

        // Check IP restriction if enabled
        if (($ipConfig['restrict_ip'] ?? false) === true) {

            $allowed = $this->ipMatches(
                request()->ip(),
                $ipConfig['allowed_ip_patterns'] ?? []
            );

            if (!$allowed) {
                session()->flash('error', 'Access denied: IP not allowed. Connect from school approved network.');
                return;
            }
        }

        // Check if device is already used by another student
        $deviceOwner = Student::where('id', '!=', $student->id)
            ->where('device_locked_until', '>=', now())
            ->where(function ($query) {
                $query->where('device_hash', $this->device_hash)
                    ->orWhere('device_local_token', $this->device_local_token);
            })
            ->first();

        if ($deviceOwner) {
            session()->flash('error', 'This device is already registered to another student for today.');
            return;
        }

        // Check if student is still within daily lock
        $isNewDay = !$student->device_locked_until
            || now()->greaterThan($student->device_locked_until);

        if (!$isNewDay) {

            if (
                $student->device_hash !== $this->device_hash ||
                $student->device_local_token !== $this->device_local_token
            ) {
                session()->flash('error', 'You are already logged into another device today.');
                return;
            }
        }

        // Update student device and login info
        $student->update([
            'device_hash' => $this->device_hash,
            'device_user_agent' => $this->device_user_agent,
            'device_screen_hash' => $this->device_screen_hash,
            'device_local_token' => $this->device_local_token,
            'device_locked_until' => now()->endOfDay(),
            'last_login_at' => now(),
            'last_ip' => request()->ip(),
        ]);

        // Create session
        session([
            'student_id' => $student->id,
            'student_logged_in' => true,
        ]);

        // Redirect to dashboard
        return redirect()->route('student.dashboard');
    }

    public function render()
    {
        return view('livewire.student.student-login');
    }
}