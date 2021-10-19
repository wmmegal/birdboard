@extends('layouts.app')

@section('content')
    <header class="flex justify-between items-center mb-4">
        <h1>Birdboard</h1>
        <a href="/projects/create" class="button">New Project</a>
    </header>
    <main class="grid grid-cols-3 gap-8">
        @forelse($projects as $project)
            @include('projects.card')
        @empty
            <div>No projects yet</div>
        @endforelse
    </main>
    <modal name="example">This is an example</modal>
    <a href="" @click.prevent="$modal.show('example')">Click</a>
@endsection
