@extends('layouts.app')

@section('content')
    <div class="lg:w-1/2 lg:mx-auto bg-card p-6 md:py-12 md:px-16 rounded shadow bg-white">
        <h1 class="text-2xl font-normal mb-10 text-center">
            Edit project
        </h1>
        <form action="{{$project->path()}}" method="post" class="container">
            @csrf
            @method('PATCH')
            @include('projects._form', [
                'buttonText' => 'Update Project'
            ])
        </form>
    </div>
@endsection
