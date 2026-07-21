<?php

namespace App\Livewire\Admin\CreateLevelAndOptions;


use Livewire\Component;
use App\Models\Level;
use App\Models\CourseOption;

class CreateCourseOption extends Component
{
    public $level_id;
    public $name;
    public $code;

    // edit state
    public $editId;
    public $editLevelId;
    public $editName;
    public $editCode;

    public function createOption()
    {
        $this->validate([
            'level_id' => 'required|exists:levels,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
        ]);

        CourseOption::create([
            'level_id' => $this->level_id,
            'name' => $this->name,
            'code' => $this->code,
        ]);

        $this->reset(['level_id', 'name', 'code']);
    }

    public function edit($id)
    {
        $option = CourseOption::findOrFail($id);

        $this->editId = $option->id;
        $this->editLevelId = $option->level_id;
        $this->editName = $option->name;
        $this->editCode = $option->code;
    }

    public function updateOption()
    {
        $this->validate([
            'editLevelId' => 'required|exists:levels,id',
            'editName' => 'required|string|max:255',
            'editCode' => 'required|string|max:50',
        ]);

        CourseOption::findOrFail($this->editId)->update([
            'level_id' => $this->editLevelId,
            'name' => $this->editName,
            'code' => $this->editCode,
        ]);

        $this->reset(['editId', 'editLevelId', 'editName', 'editCode']);
    }

    public function deleteOption($id)
    {
        CourseOption::findOrFail($id)->delete();
    }

    public function render()
    {
        return view('livewire.admin.create-level-and-options.create-course-option',  [
            'levels' => Level::all(),
            'options' => CourseOption::with('level')->latest()->get(),
        ]);
    }
}
