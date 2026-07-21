<?php

namespace App\Livewire\Admin\ManageLecturers;

use App\Models\LecturerProfile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class CreateLecturer extends Component
{
    public string $title;

    public string $full_name;

    public string $gender;

    public string $phone_number;

    public string $staff_id;

    public string $email;

    public string $password;

    public function registerLecturer()
    {
        $this->validate([
            'title' => 'nullable|string|max:50',
            'full_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'phone_number' => 'required|string|max:20',
            'staff_id' => 'required|string|unique:lecturer_profiles,staff_id',

            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $this->full_name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'lecturer',
        ]);

        LecturerProfile::create([
            'user_id' => $user->id,
            'title' => $this->title,
            'full_name' => $this->full_name,
            'gender' => $this->gender,
            'phone_number' => $this->phone_number,
            'staff_id' => $this->staff_id,
        ]);

        $this->reset();

        session()->flash('success', 'Lecturer registered successfully.');
    }

    public function render()
    {
        return view('livewire.admin.manage-lecturers.create-lecturer', [
            'lecturers' => LecturerProfile::whereHas('user', function ($query) {
                $query->where('role', 'lecturer');
            })->latest()->get()
        ]);
    }
}
