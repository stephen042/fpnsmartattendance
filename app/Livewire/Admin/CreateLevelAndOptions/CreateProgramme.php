<?php

namespace App\Livewire\Admin\CreateLevelAndOptions;


use Livewire\Component;
use App\Models\Programme;

class CreateProgramme extends Component
{
    public $name = '';

    public function createProgramme()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        Programme::create([
            'name' => $this->name,
        ]);

        $this->reset('name');

        session()->flash('success', 'Programme created successfully.');
    }

    public function deleteProgramme($id)
    {
        Programme::findOrFail($id)->delete();

        session()->flash('success', 'Programme deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.create-level-and-options.create-programme', [
            'programmes' => Programme::latest()->get(),
        ]);
    }
}
