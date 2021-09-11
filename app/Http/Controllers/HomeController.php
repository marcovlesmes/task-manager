<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $tasks = Task::get()->sortBy('priority');
        $projects = $tasks->map(function ($task) {
            return $task->project;
        })->unique('id');
        return view('welcome', compact('projects', 'tasks'));
    }
}
