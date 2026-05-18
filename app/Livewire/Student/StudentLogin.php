<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Student;

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

        // 🔥 IMPORTANT: do NOT block UI here
        $this->device_ready = false;
    }

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

    public function setDeviceData(array $data)
    {
        logger('Device data received', $data); // 👈 ADD THIS
        
        $this->device_hash = $data['device_hash'] ?? '';
        $this->device_screen_hash = $data['device_screen_hash'] ?? '';
        $this->device_local_token = $data['device_local_token'] ?? '';
        $this->device_user_agent = $data['device_user_agent'] ?? '';

        $this->device_ready = true;
    }

    public function login()
    {
        $this->validate(['application_number' => 'required|string']);

        // 1. Get the student trying to log in
        $student = Student::where('application_number', $this->application_number)
            ->where('is_active', true)
            ->first();

        if (!$student) {
            session()->flash('error', 'Invalid Application Number');
            return;
        }

        // 2. DEVICE-TO-USER LOCK: Check if this browser is already taken today
        // We look for ANY OTHER student who has this device hash and is locked for today
        $deviceOwner = Student::where('id', '!=', $student->id)
            ->where('device_locked_until', '>=', now())
            ->where(function ($query) {
                $query->where('device_hash', $this->device_hash)
                    ->orWhere('device_local_token', $this->device_local_token);
            })
            ->first();

        if ($deviceOwner) {
            session()->flash('error', 'This browser is already registered to another student for today.');
            return;
        }

        // 3. USER-TO-DEVICE LOCK: Standard check (Is this student trying to use a different device?)
        $isNewDay = !$student->device_locked_until || now()->greaterThan($student->device_locked_until);

        if (!$isNewDay) {
            // Strict match for the student's existing daily lock
            if ($student->device_hash !== $this->device_hash || $student->device_local_token !== $this->device_local_token) {
                session()->flash('error', 'You are already logged into another device/browser today.');
                return;
            }
        }

        // 4. Update/Bind the lock
        $student->update([
            'device_hash' => $this->device_hash,
            'device_user_agent' => $this->device_user_agent,
            'device_screen_hash' => $this->device_screen_hash,
            'device_local_token' => $this->device_local_token,
            'device_locked_until' => now()->endOfDay(),
            'last_login_at' => now(),
            'last_ip' => request()->ip(),
        ]);

        session(['student_id' => $student->id, 'student_logged_in' => true]);

        return redirect()->route('student.dashboard');
    }

    public function render()
    {
        return view('livewire.student.student-login');
    }
}
