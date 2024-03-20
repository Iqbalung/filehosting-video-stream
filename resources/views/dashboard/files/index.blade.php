<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<x-app-layout title="My Files">
    <x-slot name="header">
        <h2 class="title is-2">
            {{ __('My Files') }}
        </h2>
    </x-slot>

    <div class="field">
        @if ($errors->any())
            <div class="notification is-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <div class="columns mb-3">
        <div class="column is-3">
            <div class="box">
                <form action="{{ route('dashboard.directory.store', ['folder_id' => request()->has('folder_id') ? request()->folder_id : '']) }}" method="POST">
                    @csrf
                    <label class="label">Create Folder</label>
                    <div class="field has-addons is-fullwidth">
                        <div class="control">
                            <input value="{{ old('folder_name') }}" class="input @error('folder_name')is-danger @enderror" type="text" name="folder_name" placeholder="Create new folder">
                        </div>
                        <div class="control">
                            <button class="button is-primary">
                                Add
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <nav class="panel">
                <form action="{{ route('dashboard.directory.edit') }}" method="POST">
                    @csrf

                    <p class="panel-heading">
                        Folder
                    </p>
                    @if (request()->has('folder_id'))
                        <a href="{{ route('dashboard.files.index', ['folder_id' => $parrentDirectory]) }}" class="panel-block">
                            ...
                        </a>
                    @endif
                    @foreach ($directories as $directory)
                    <a href="{{ route('dashboard.files.index', ['folder_id' => $directory->id]) }}" class="panel-block">
                        <label class="checkbox">
                        <input type="checkbox" name="directories[]" value="{{ $directory->id }}" {{ in_array($directory->id, explode(',', request()->get('folder_id'))) ? 'checked' : '' }}>
                            {{ $directory->name }}
                        </label>
                    </a>
                    @endforeach

                    <div class="panel-block">
                        <div class="columns">
                            <div class="column is-6">
                                <input type="submit" class="button is-danger is-outlined is-fullwidth" value="Delete" name="delete">
                            </div>
                            <div class="column is-6">
                                <input type="submit" class="button is-primary is-outlined is-fullwidth" value="Rename" name="update">
                            </div>
                        </div>
                    </div>
                </form>
            </nav>
        </div>
        <div class="column">
            <div class="field">
                <label class="label">All Files in Directory {{ $directoryName }}</label>
            </div>
            <div class="table-container">
                <table class="table is-fullwidth">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Size</th>
                        <th>View</th>
                        <th>Download</th>
                        <th>link</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($files as $file)

                        <tr>
                            <td>
                                <label class="checkbox is-primary">
                                    <input type="checkbox">
                                </label>
                            </td>
                            <td>
                                <figure class="image is-48x48">
                                    <img src="{{ $file->thumbnail }}" alt="{{ $file->client_original_name }}">
                                </figure>
                            </td>
                            <td><a href="{{ route('file-show', $file->code) }}">{{ $file->client_original_name }}</a>
                            <br>
                            
                            </td>
                            <td>{{ $file->size_format }}</td>
                            <td>0</td>
                            <td>0</td>
                            <td>
                            <a href="{{ env('APP_URL') }}/download/{{ $file->name }}">{{ env('APP_URL') }}/download/{{ $file->name }} </a> 
                            <a class="button is-primary" href="{{ env('APP_URL') }}/download/{{ $file->name }}">Open </a> 
                            </td>
                            <td>
                                <livewire:dashboard.file-button :file="$file"/>
                                <a  href="{{ env('APP_URL') }}/delete/{{ $file->id }}" class="button is-small is-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{ $files->withQueryString()->links() }}

        </div>
    </div>
</x-app-layout>
<script type="text/javascript">
   
$(document).ready(function(){
  $('input[type="checkbox"][name="directories[]"]').click(function(){
    console.log('clicked');
   
      var id = $(this).val();

        var checkedValues = $('input[type="checkbox"][name="directories[]"]:checked').map(function() {
            return this.value;
        }).get();

        var checkedValuesString = checkedValues.join(',');
        window.location.href = window.location.href.split('?')[0] + '?folder_id=' + checkedValuesString;
    
  });
});


</script>
