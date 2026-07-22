<?php

namespace App\Livewire\Admin;

use App\Models\AcademicSession;
use App\Models\Department;
use App\Models\IpRestriction;
use App\Models\Semester;
use App\Models\Settings as SettingsModel;
use Livewire\Component;

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

    public function mount()
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
        // Retrieve active patterns
        $activePatterns = IpRestriction::where('is_active', true)
            ->pluck('ip_pattern')
            ->values()
            ->toArray();

        // Find existing setting or instantiate new one
        $setting = SettingsModel::first();

        if (! $setting) {
            SettingsModel::create([
                'session' => $this->active_session_id,
                'ip_config' => [
                    'restrict_ip' => $this->restrict_ip,
                    'allowed_ip_patterns' => $activePatterns,
                ],
            ]);
        } else {
            $ipConfig = $setting->ip_config ?? [];
            $ipConfig['restrict_ip'] = $this->restrict_ip;
            $ipConfig['allowed_ip_patterns'] = $activePatterns;

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

        IpRestriction::create([
            'ip_pattern' => trim($this->new_ip_pattern),
            'label' => trim($this->new_ip_label),
            'is_active' => true,
        ]);

        $this->syncIpSettings();
        $this->reset(['new_ip_pattern', 'new_ip_label']);
    }

    public function toggleIpStatus($id): void
    {
        $ip = IpRestriction::findOrFail($id);
        $ip->update(['is_active' => ! $ip->is_active]);

        $this->syncIpSettings();
    }

    public function deleteIpRestriction($id): void
    {
        IpRestriction::findOrFail($id)->delete();

        $this->syncIpSettings();
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
    }

    public function deleteDepartment($id)
    {
        Department::findOrFail($id)->delete();
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
