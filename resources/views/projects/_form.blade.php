<div class="field mb-6">
    <label for="title" class="label text-sm mb-2 block">Title</label>
    <div class="control">
        <input
            class="input bg-transparent border border-muted-light rounded p-2 text-xs w-full"
            type="text"
            id="title"
            name="title"
            placeholder="Tittle"
            value="{{$project->title}}">
    </div>
</div>
<div class="field mb-6">
    <label for="description" class="label text-sm mb-2 block">Description</label>
    <div class="control">
                <textarea
                    class="textarea bg-transparent border border-muted-light rounded p-2 text-xs w-full"
                    name="description"
                    id="description">{{$project->description}}</textarea>
    </div>
</div>
<div class="field mb-6">
    <div class="control">
        <button type="submit" class="button is-link mr-3">{{$buttonText}}</button>
        <a href="{{$project->path()}}">Cancel</a>
    </div>
</div>

@include('errors')
