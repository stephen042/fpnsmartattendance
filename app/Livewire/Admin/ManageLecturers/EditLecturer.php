<?php

namespace App\Livewire\Admin\ManageLecturers;

use App\Models\LecturerProfile;
use App\Models\User;
use Livewire\Component;

class EditLecturer extends Component
{
    public User $user;

    public int $lecturer;

    public string $lecturerId;

    public string $title;

    public string $full_name;

    public string $gender;

    public string $phone_number;

    public string $staff_id;

    public function mount($id)
    {
        $lecturer = LecturerProfile::with('user')->findOrFail($id);

        $this->lecturerId = $lecturer->id;
        $this->title = $lecturer->title;
        $this->full_name = $lecturer->full_name;
        $this->gender = $lecturer->gender;
        $this->phone_number = $lecturer->phone_number;
        $this->staff_id = $lecturer->staff_id;
    }

    public function updateLecturer()
    {
        $this->validate([
            'title' => 'nullable|string|max:50',
            'full_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'phone_number' => 'required|string|max:20',
            'staff_id' => 'required|string|unique:lecturer_profiles,staff_id,'.$this->lecturerId,
        ]);

        $lecturer = LecturerProfile::with('user')->findOrFail($this->lecturerId);

        $lecturer->update([
            'title' => $this->title,
            'full_name' => $this->full_name,
            'gender' => $this->gender,
            'phone_number' => $this->phone_number,
            'staff_id' => $this->staff_id,
        ]);

        $lecturer->user->update([
            'name' => $this->full_name,
        ]);

        session()->flash('success', 'Lecturer details updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.manage-lecturers.edit-lecturer');
    }
}
