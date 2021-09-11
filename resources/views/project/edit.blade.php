@extends('layouts.app')

@section('content')
    <h1 class="w-full block text-gray-100 text-center font-bold text-3xl py-3 my-8">Task Manager<br>Edit project</h1>
    <nav class="p-4 bg-gray-700 my-4 shadow rounded">
        <a href="{{ route('index') }}" class="text-white text-sm w-full my-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
              </svg>
              App
        </a>
    </nav>
    <div class="flex justify-between">
        <form class="flex flex-col p-4 w-2/5" action="{{ route('project.update', $project->id) }}" method="POST">
            @method('PATCH')
            @csrf
            <div class="flex flex-col">
                <label for="name">Name</label>
                <input id="name" class="p-2 rounded text-gray-900" type="text" name="name" value="{{ $project->name }}">
            </div> 
            <button class="p-2 rounded bg-blue-500 text-white my-2" type="submit">Update</button>
        </form>
        <form class="p-4" action="{{ route('project.destroy', $project->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <p>Remove project</p>
            <button class="p-2 rounded bg-red-500 text-white my-2" type="submit">Delete</button>
        </form>
        <div class="p-4 flex flex-col w-1/5">
            <h2 class="text-2xl font-bold">Edit project tasks</h2>
            @forelse ($project->tasks as $task)
                <a class="my-2" href="{{ route('task.edit', $task->id) }}">{{ $task->name }}</a>
            @empty
                The project dont have task assigned
            @endforelse
        </div>
    </div>
@endsection
