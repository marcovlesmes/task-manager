<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'project_name' => 'required|string',
            'task_name' => 'required|string',
        ])->validate();

        $project = new Project();
        $project->name = $request->project_name;
        $project->created_at = Carbon::now();
        $project->save();

        $task = new Task();
        $task->name = $request->task_name;
        $task->project_id = $project->id;
        $task->priority = Task::get()->count();
        $task->created_at = Carbon::now();
        $task->save();

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::find($id);
        return view('project.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'name' => 'required|string'
        ])->validate();

        $project = Project::find($id);
        $project->name = $request->name;
        $project->updated_at = Carbon::now();
        $project->save();

        return redirect()->route('index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Project::find($id)->delete();
        return redirect()->route('index');
    }
}
