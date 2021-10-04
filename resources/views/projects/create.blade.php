@extends('layouts.app')

@section('content')
    <div class="lg:w-1/2 lg:mx-auto bg-card p-6 md:py-12 md:px-16 rounded shadow bg-white">
        <h1 class="text-2xl font-normal mb-10 text-center">
            Let's start something new
        </h1>
        <form action="/projects" method="post" class="container">
            @csrf
            @include('projects._form', [
                'project' => new App\Models\Project,
                'buttonText' => 'Create Project'
            ])
        </form>
    </div>
@endsection
