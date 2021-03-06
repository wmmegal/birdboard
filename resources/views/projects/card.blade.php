<div class="card flex flex-col">
    <h3 class="mb-2 py-4 border-l-4 border-blue-300 -mx-4 pl-4"><a href="{{$project->path()}}">{{$project->title}}</a>
    </h3>
    <div class="text-gray-400 flex-1">
        {{$project->description}}
    </div>
    @can('manage', $project)
        <footer>
            <form method="POST" action="{{$project->path()}}" class="text-right">
                @method('DELETE')
                @csrf
                <button type="submit" class="text-xs">Delete</button>
            </form>
        </footer>
    @endcan
</div>
