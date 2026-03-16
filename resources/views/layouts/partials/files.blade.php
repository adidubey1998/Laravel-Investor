<div class="Corporate-box">
    @foreach($files as $file)
        <p>
            <a href="{{ asset($file->file_path) }}" target="_blank">
                {{ $file->title }}
            </a>
        </p>
    @endforeach
</div>
