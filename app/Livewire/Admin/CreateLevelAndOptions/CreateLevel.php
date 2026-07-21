<?php

namespace App\Livewire\Admin\CreateLevelAndOptions;

use App\Models\Level;
// use Illuminate\Support\Str;
use Livewire\Component;

class CreateLevel extends Component
{
    public $name = '';
    public $slug = '';

    public $editId;
    public $editName = '';
    public $editSlug = '';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:levels,slug',
        ];
    }

    public function createLevel()
    {
        $this->validate();

        Level::create([
            'name' => $this->name,
            'slug' => $this->slug,
        ]);

        $this->reset(['name', 'slug']);

        session()->flash('success', 'Level created successfully.');
    }

    public function edit(Level $level)
    {
        $this->editId = $level->id;
        $this->editName = $level->name;
        $this->editSlug = $level->slug;

        $this->modal('edit-level')->show();
    }

    public function updateLevel()
    {
        $this->validate([
            'editName' => 'required|string|max:255',
            'editSlug' => 'required|string|max:255|unique:levels,slug,' . $this->editId,
        ]);
        // dd($this->editName, $this->editSlug);

        Level::findOrFail($this->editId)->update([
            'name' => $this->editName,
            'slug' => $this->editSlug,
        ]);

        session()->flash('success', 'Level updated successfully.');

        $this->modal('edit-level')->close();
    }

    public function deleteLevel()
    {
        Level::findOrFail($this->editId)->delete();

        session()->flash('success', 'Level deleted successfully.');

        $this->modal('edit-level')->close();
    }

    // public function updatedName()
    // {
    //     $this->slug = Str::slug($this->name);
    // }

    public function render()
    {
        return view('livewire.admin.create-level-and-options.create-level', [
            'levels' => Level::latest()->get(),
        ]);
    }
}
