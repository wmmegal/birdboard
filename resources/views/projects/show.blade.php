@extends('layouts.app')

@section('content')
    <header class="flex justify-between items-center mb-4">
        <p class="text-gray-500">
            <a href="{{url('/projects')}}">My projetcs</a> / {{$project->title}}
        </p>
        <div>
            <a href="/projects/create" class="button">New Project</a>
            <a href="{{$project->path()}}/edit" class="button">Edit Project</a>
        </div>
    </header>
    <main class="grid grid-cols-12 gap-8">
        <div class="col-span-9">
            <div class="mb-8">
                <h2 class="text-gray-500 mb-3">Tasks</h2>
                @foreach($project->tasks as $task)
                    <div class="card mb-4">

                        <form method="POST" action="{{$task->path()}}">
                            @method('PATCH')
                            @csrf

                            <div class="flex">
                                <input name="body" type="text" value="{{$task->body}}"
                                       class="w-full {{$task->completed ? 'text-gray' : ''}}">
                                <input type="checkbox" name="completed"
                                       onchange="this.form.submit()" {{$task->completed ? 'checked' : ''}}>
                            </div>
                        </form>
                    </div>
                @endforeach
                <div class="mb-4">
                    <form action="{{ $project->path() . '/tasks' }}" method="POST">
                        @csrf
                        <input type="text" placeholder="Add new task" class="card w-full" name="body">
                    </form>
                </div>
            </div>
            <h2 class="text-gray-500 mb-3">General Notes</h2>
            <form method="POST" action="{{ $project->path() }}">
                @csrf
                @method('PATCH')
                <textarea
                    name="notes"
                    class="card w-full mb-4"
                    style="min-height: 200px"
                    placeholder="General notes">{{ $project->notes }}</textarea>
                <button type="submit" class="button">Save</button>
            </form>
            @include('errors')
        </div>
        <div class="col-span-3">
            @include('projects.card')
            @include('projects.activity.card')
            @can('manage', $project)
                @include('projects.invite')
            @endcan

        </div>
    </main>

@endsection
