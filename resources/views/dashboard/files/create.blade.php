<x-app-layout title="Upload File">
    <x-slot name="header">
        <h2 class="title is-2">
            {{ __('Upload File') }}
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

    <div class="box my-3 has-text-centered">
        <form method="POST" enctype="multipart/form-data" action="{{ route('dashboard.files.store') }}">
            @csrf
            <div class="field">
                <label for="" class="label">Pilih 1 atau beberapa file sekaligus</label>
                <input id="video" name="video[]" type="file" class="control" style="border: dashed teal 2px; padding: 30px 30px 30px 30px !important; border-radius: 1%" multiple>
                <div id="fileInfo">tes</div>
            </div>
            <div class="field">
                <div class="control">
                    <label for="" class="label">Select Folder</label>
                    <div class="select">
                        <select name="directory_id">
                            <option value="">/</option>
                            @foreach ($directories as $directory)
                                <option value="{{ $directory->id }}">/{{ $directory->name }}</option>
                                @if (!blank($directory->childrenDirectory))
                                    <x-bulma.nested-select-directory :directories="$directory->childrenDirectory" :fromRoot="$directory->name" :parrentDirectoryName="$directory->name"/>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="field">
                <button class="button is-primary">Upload Video</button>
            </div>
        </form>
    </div>

</x-app-layout>
<script>
document.getElementById('video').addEventListener('change', function() {
  var output = '';
  for (var i = 0; i < this.files.length; i++) {
    var file = this.files[i];
    output += '<p>File name ' + (i+1) + ': ' + file.name + '</p>';
    output += '<p>File size ' + (i+1) + ': ' + file.size + ' bytes</p>';
    output += '<p>File type ' + (i+1) + ': ' + file.type + '</p>';
    output += '<hr>';
  }
  document.getElementById('fileInfo').innerHTML = output;
});
</script>