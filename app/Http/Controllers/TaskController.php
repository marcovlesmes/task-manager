<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Task::get()->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|string',
            'project_id' => 'required|integer'
        ])->validate();

        $task = new Task();
        $task->name = $request->name;
        $task->project_id = $request->project_id;
        $task->priority = Task::get()->count();
        $task->created_at = Carbon::now();
        $task->save();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);
        return view('task.edit', compact('task'));
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

        $task = Task::find($id);
        $task->name = $request->name;
        $task->updated_at = Carbon::now();
        $task->save();

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
        Task::find($id)->delete();
        return redirect()->route('index');
    }

    public function bash(Request $request)
    {
        Validator::make($request->all(), ['data' => 'required|string'])->validate();
        $data = json_decode($request->data);

        for ($i = 0; $i < count($data); $i++) {
            Task::find($data[$i]->id)->update(['priority' => $i]);
        }

        return back();
    }
}
