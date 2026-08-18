<?php

namespace App\Livewire\Admin;

use App\Models\AcademicSession;
use App\Models\Department;
use App\Models\IpRestriction;
use App\Models\Semester;
use App\Models\Settings as SettingsModel;
use Livewire\Component;
use Illuminate\Http\Request;

class Settings extends Component
{
    // Academic Session Creation Form
    public string $session_name = '';

    // Academic Semester Creation Form
    public string $semester_name = '';

    // Active Academic Context Form
    public ?int $active_session_id = null;

    public ?int $active_semester_id = null;

    // IP Restriction Form & Lists
    public bool $restrict_ip = true;

    public string $new_ip_pattern = '';

    public string $new_ip_label = '';

    // Department Form
    public string $department_name = '';

    public string $department_code = '';

    // Current IP Address
    public ?string $current_ip = null;

    public bool $show_ip = false;

    public function mount(Request $request)
    {
        $activeSession = AcademicSession::where('is_active', true)->first();
        $activeSemester = Semester::where('is_active', true)->first();

        $this->active_session_id = $activeSession?->id;
        $this->active_semester_id = $activeSemester?->id;

        $setting = SettingsModel::first();
        if ($setting && isset($setting->ip_config['restrict_ip'])) {
            $this->restrict_ip = (bool) $setting->ip_config['restrict_ip'];
        }
    }

    // --- ACADEMIC SESSION ACTIONS ---
    public function createAcademicSession()
    {
        $this->validate([
            'session_name' => 'required|string|unique:academic_sessions,name',
        ]);

        AcademicSession::create(['name' => $this->session_name]);
        $this->reset('session_name');
        session()->flash('success', 'Academic session created.');
    }

    public function deleteAcademicSession($id)
    {
        AcademicSession::findOrFail($id)->delete();
        session()->flash('success', 'Academic session deleted.');
    }

    // --- SEMESTER ACTIONS ---
    public function createSemester()
    {
        $this->validate([
            'semester_name' => 'required|string|unique:semesters,name',
        ]);

        Semester::create(['name' => $this->semester_name]);
        $this->reset('semester_name');
        session()->flash('success', 'Semester created.');
    }

    public function deleteSemester($id)
    {
        Semester::findOrFail($id)->delete();
        session()->flash('success', 'Semester deleted.');
    }

    // --- CONTEXT SAVE ---
    public function saveAcademicContext()
    {
        $this->validate([
            'active_session_id' => 'required|exists:academic_sessions,id',
            'active_semester_id' => 'required|exists:semesters,id',
        ]);

        // Reset previous active flags and set new active session
        AcademicSession::query()->update(['is_active' => false]);
        AcademicSession::where('id', $this->active_session_id)->update(['is_active' => true]);

        // Reset previous active flags and set new active semester
        Semester::query()->update(['is_active' => false]);
        Semester::where('id', $this->active_semester_id)->update(['is_active' => true]);

        session()->flash('success', 'Active academic context updated successfully.');
    }

    // Reusable helper method to sync settings with DB
    private function syncIpSettings(): void
    {
        // Retrieve all IP restrictions (both active and inactive)
        $allIpRestrictions = IpRestriction::all();

        // Get active patterns for the settings
        $activePatterns = $allIpRestrictions
            ->where('is_active', true)
            ->pluck('ip_pattern')
            ->values()
            ->toArray();

        // Find existing setting or instantiate new one
        $setting = SettingsModel::first();

        $ipConfig = [
            'restrict_ip' => $this->restrict_ip,
            'allowed_ip_patterns' => $activePatterns,
        ];

        if (! $setting) {
            SettingsModel::create([
                'session' => $this->active_session_id ?? 'default',
                'ip_config' => $ipConfig,
            ]);
        } else {
            $setting->update([
                'ip_config' => $ipConfig,
            ]);
        }
    }

    // Toggle master switch (Restrict IP ON/OFF)
    public function updatedRestrictIp(): void
    {
        $this->syncIpSettings();
    }

    // --- IP RESTRICTION ACTIONS ---
    public function addIpRestriction(): void
    {
        $this->validate([
            'new_ip_pattern' => 'required|string',
            'new_ip_label' => 'nullable|string|max:100',
        ]);

        // Check if IP pattern already exists
        $exists = IpRestriction::where('ip_pattern', trim($this->new_ip_pattern))->exists();

        if ($exists) {
            session()->flash('error', 'This IP pattern already exists.');
            return;
        }

        // Create new IP restriction
        IpRestriction::create([
            'ip_pattern' => trim($this->new_ip_pattern),
            'label' => trim($this->new_ip_label) ?: null,
            'is_active' => true,
        ]);

        // Sync settings with updated IP restrictions
        $this->syncIpSettings();

        // Reset form fields
        $this->reset(['new_ip_pattern', 'new_ip_label']);

        session()->flash('success', 'IP restriction added successfully.');
    }

    public function toggleIpStatus($id): void
    {
        $ip = IpRestriction::findOrFail($id);
        $ip->update(['is_active' => ! $ip->is_active]);

        // Sync settings with updated IP restrictions
        $this->syncIpSettings();

        $status = $ip->is_active ? 'enabled' : 'disabled';
        session()->flash('success', "IP restriction {$status} successfully.");
    }

    public function deleteIpRestriction($id): void
    {
        $ip = IpRestriction::findOrFail($id);
        $pattern = $ip->ip_pattern;
        $ip->delete();

        // Sync settings with updated IP restrictions
        $this->syncIpSettings();

        session()->flash('success', "IP restriction '{$pattern}' deleted successfully.");
    }

    // --- DEPARTMENT ACTIONS ---
    public function createDepartment()
    {
        $this->validate([
            'department_name' => 'required|string|max:255',
            'department_code' => 'required|string|max:20|unique:departments,code',
        ]);

        Department::create([
            'name' => $this->department_name,
            'code' => strtoupper($this->department_code),
        ]);

        $this->reset(['department_name', 'department_code']);
        session()->flash('success', 'Department created successfully.');
    }

    public function deleteDepartment($id)
    {
        $department = Department::findOrFail($id);
        $name = $department->name;
        $department->delete();

        session()->flash('success', "Department '{$name}' deleted successfully.");
    }

    // --- GET CURRENT IP ADDRESS ---
    public function getCurrentIp(Request $request): void
    {
        $this->show_ip = !$this->show_ip;

        if ($this->show_ip) {
            // Get the client's IP address
            $ip = $request->ip();

            // Check for proxy/forwarded headers
            if ($request->hasHeader('X-Forwarded-For')) {
                $ip = $request->header('X-Forwarded-For');
                // If multiple IPs, take the first one
                if (str_contains($ip, ',')) {
                    $ip = explode(',', $ip)[0];
                }
            } elseif ($request->hasHeader('X-Real-IP')) {
                $ip = $request->header('X-Real-IP');
            }

            $this->current_ip = trim($ip);
        } else {
            $this->current_ip = null;
        }
    }

    // Helper method to check if current IP is allowed
    public function isCurrentIpAllowed(): bool
    {
        if (!$this->current_ip) {
            return true;
        }

        $setting = SettingsModel::first();
        if (!$setting || !isset($setting->ip_config['allowed_ip_patterns'])) {
            return true;
        }

        $allowedPatterns = $setting->ip_config['allowed_ip_patterns'];

        foreach ($allowedPatterns as $pattern) {
            if ($this->matchIpPattern($this->current_ip, $pattern)) {
                return true;
            }
        }

        return false;
    }

    private function matchIpPattern($ip, $pattern): bool
    {
        // Convert pattern to regex
        $pattern = str_replace('.', '\.', $pattern);
        $pattern = str_replace('*', '.*', $pattern);
        $pattern = '/^' . $pattern . '$/';

        return preg_match($pattern, $ip) === 1;
    }

    public function render()
    {
        return view('livewire.admin.settings', [
            'academicSessions' => AcademicSession::latest()->get(),
            'semesters' => Semester::latest()->get(),
            'ipRestrictions' => IpRestriction::latest()->get(),
            'departments' => Department::latest()->get(),
        ]);
    }
}
