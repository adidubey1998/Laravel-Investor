<div class="box-inner">

    <h3>{{ $tab->title }}</h3>

    {{-- ================= FILES (PDF / MP4 / XLS) ================= --}}
    @if($tab->content_type === 'files')
        <div class="Corporate-box">
            @forelse($tab->files as $file)
                <p>
                    <a href="{{ asset($file->file_path) }}"
                       target="_blank">
                        {{ $file->title }}
                    </a>
                </p>
            @empty
                <p>No documents available.</p>
            @endforelse
        </div>
    @endif

    {{-- ================= TABLE ================= --}}
    @if($tab->content_type === 'table')
        <table class="table table-bordered">
            <tbody>
                @forelse($tab->tableRows as $row)
                    <tr>
                        <td width="40%"><strong>{{ $row->column_name }}</strong></td>
                        <td>{{ $row->column_value }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center">
                            No data available
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif

    {{-- ================= HTML CONTENT ================= --}}
    @if($tab->content_type === 'html')
        {!! $tab->html_content !!}
    @endif

</div>
