<table class="table table-bordered">
    @foreach($rows as $row)
        <tr>
            <td>{{ $row->column_name }}</td>
            <td>{{ $row->value }}</td>
        </tr>
    @endforeach
</table>
