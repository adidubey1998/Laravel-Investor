@php

    $hasContent = $tab->hasContent();

    // Auto fallback → If parent empty → show first child content
    if(!$hasContent && $tab->childrenRecursive->count()){
        $tab = $tab->firstChildWithContent() ?? $tab;
    }

@endphp


<div class="tab-pane {{ $isActive ?? false ? 'show active' : '' }}"
     id="tab-{{ $tab->id }}">


    <h2>{{ $tab->page_heading ?? $tab->name }}</h2>


    {{-- DESCRIPTION --}}
    @if(!empty($tab->page_description))
        <p>{!! $tab->page_description !!}</p>
    @endif


    {{-- FILES --}}
    @if($tab->files->count())
    <ul>
        @foreach($tab->files as $file)

            @php
                $extension = strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION));
                $fileNameWithoutExt = pathinfo($file->file_path, PATHINFO_FILENAME);
                $displayName = str_replace('_', ' ', $fileNameWithoutExt);
            @endphp

            <li>

                {{-- VIDEO --}}
                @if(in_array($extension, ['mp4','webm','ogg']))
                    <a href="{{ asset($file->file_path) }}" target="_blank">
                        🎥 {{ $displayName }}
                    </a>

                {{-- AUDIO --}}
                @elseif(in_array($extension, ['mp3','wav','aac']))
                    <a href="{{ asset($file->file_path) }}" target="_blank">
                        🎵 {{ $displayName }}
                    </a>

                {{-- NORMAL FILE --}}
                @else
                    <a href="{{ asset($file->file_path) }}" target="_blank">
                        📄 {{ $displayName }}
                    </a>
                @endif

            </li>

        @endforeach
    </ul>
@endif

    {{-- TABLE --}}
    @if($tab->tableRows->count())

        <table class="table table-bordered mt-4">
         <thead>
        <tr>
            <th style="width:80px;">Sno</th>
            <th>Name of the Director</th>
            <th>Designation</th>
            <th style="width:150px;">Profile</th>
        </tr>
    </thead>
            <tbody>

            @foreach($tab->tableRows as $row)
                <tr>
                 <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->column_name }}</td>
                    <td>{{ $row->column_value }}</td>
                    <td>
                    @if($row->file_path)

                    <a href="#"
                    class="viewProfile text-blue-600 underline"
                    data-profile='{!! $row->file_path !!}'>
                    View Profile
                    </a>

                    @endif
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>

    @endif

</div>


{{-- RECURSIVE CHILD CONTENT --}}
@foreach($tab->childrenRecursive as $child)

    @include('layouts.investor-content', [
        'tab' => $child,
        'isActive' => false
    ])

@endforeach
<div id="profileModal"
     style="display:none;
            position:fixed;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background:rgba(0,0,0,0.6);
            align-items:center;
            justify-content:center;">

    <div style="background:white;
                width:60%;
                max-height:80vh;
                overflow:auto;
                padding:30px;
                border-radius:8px;
                position:relative;">

        <span id="closeProfile"
              style="position:absolute;
                     top:10px;
                     right:15px;
                     cursor:pointer;
                     font-size:22px;">
            ✕
        </span>

        <div id="profileContent"></div>

    </div>

</div>
<script>

document.querySelectorAll(".viewProfile").forEach(function(btn){

    btn.addEventListener("click", function(e){

        e.preventDefault();

        let profile = this.dataset.profile;

        document.getElementById("profileContent").innerHTML = profile;

        document.getElementById("profileModal").style.display = "flex";

    });

});

document.getElementById("closeProfile").onclick = function(){

    document.getElementById("profileModal").style.display = "none";

};

</script>
