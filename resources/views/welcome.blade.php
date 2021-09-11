@extends('layouts.app')

@section('content')
    <h1 class="w-full block text-gray-100 text-center font-bold text-3xl py-3 my-8">Task Manager</h1>
    <ul class="flex flex-col items-center">
        <li x-ref="createProject" class="flex rounded my-4 hidden">
            <form action="{{ route('project.store') }}" method="POST">
                <input class="p-2 rounded" type="text" name="project_name" placeholder="New project name">
                <input class="p-2 rounded" type="text" name="task_name" placeholder="New task">
                <button class="p-2 rounded bg-blue-500 text-white" type="submit">Add</button>
            </form>
        </li>
        <li x-ref="createTask" class="flex flex-col rounded my-4 hidden">
            <form action="{{ route('task.store') }}" method="POST">
                <input class="p-2 rounded" type="text" name="name" placeholder="New task">
                <input type="hidden" name="project_id">
                <button class="p-2 rounded bg-blue-500 text-white" type="submit">Add Task</button>
            </form>
            <a href="{{ route('project.edit', 0) }}" class="text-white text-sm w-full my-2">Edit Project</a>
        </li>
        <li class="mx-3 relative bg-gray-600 text-white p-4 bg-opacity-25 rounded overflow-y-hidden flex-grow">
            <!-- header -->
            <span class="flex justify-center rounded m-3">
                Tasks in
                <select x-ref="projectSelect" x-on:change="changeProject(event)" class="bg-gray-800 px-4 py-1 mx-4"
                    name="project">
                    <option value="all">all projects</option>
                    @foreach ($projects as $project)
                        <option class="border-l-2 border-{{ str_replace(' ', '-', $project->name) }}"
                            value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                    <option value="new">add new...</option>
                </select>
            </span>
            <!-- body -->
            <div class="overflow-y-auto max-h-75">
                <ul x-ref="taskList" class="min-h-5">
                    @forelse ($tasks as $task)
                        <li class="p-2 my-1 cursor-move border-l-2 border-{{ str_replace(' ', '-', $task->project->name) }}"
                            draggable="true" x-on:drag="drag(event)" x-on:dragover="dragOver(event)"
                            x-on:dragenter="dragEnter(event)" x-on:dragleave="dragLeave(event)" x-on:drop="drop(event)"
                            data-project="{{ $task->project->id }}" data-priority="{{ $task->priority }}" data-id="{{ $task->id }}">
                            {{ $task->name }}</li>
                    @empty
                        <li><small class="text-gray-500 text-center p-4">Free of tasks</small></li>
                    @endforelse
                </ul>
            </div>
        </li>
        <li>
            <form x-ref="saveForm" action="{{ route('save.bash') }}" method="post">
                @csrf
                <input id="data" type="hidden" name="data">
                <button @click="save(event)" type="submit"
                    class="bg-blue-400 p-2 my-4 rounded text-gray-300 disabled:bg-gray-400" disabled>Save</button>
            </form>
        </li>
    </ul>
@endsection
