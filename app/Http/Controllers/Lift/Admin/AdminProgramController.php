<?php

namespace App\Http\Controllers\Lift\Admin;

use App\Models\Lift\Program;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminProgramController extends Controller
{
    public function index()
    {
        $programs = Program::orderBy('name')->get();

        return inertia('Lift/Admin/Programs/ProgramsIndex', [
            'programs' => $programs,
        ]);
    }

    public function create()
    {
        return inertia('Lift/Admin/Programs/ProgramsForm', [
            'program' => new Program(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:lift_programs',
        ]);

        $program = Program::create($validated);

        return redirect()->route('lift.admin.programs.edit', $program);
    }

    public function edit(Program $program)
    {
        return inertia('Lift/Admin/Programs/ProgramsForm', [
            'program' => $program,
        ]);
    }

    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:lift_programs,name,' . $program->id,
        ]);

        $program->update($validated);

        return redirect()->route('lift.admin.programs.edit', $program);
    }
}
