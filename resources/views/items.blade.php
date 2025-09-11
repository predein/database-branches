<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Database branches</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <script src="{{ asset('js/bootstrap.js') }}" defer></script>

</head>
<body>

<nav class="mb-3">
    <div class="btn-group" role="group">
        <a href="{{ url('/switch?branch_id=0') }}"
           class="btn btn-sm {{ ($branch_id ?? 0) == 0 ? 'btn-primary' : 'btn-outline-primary' }}">Main</a>
        @foreach($branches as $branch)
            <a href="{{ url('/switch?branch_id='.$branch->id) }}"
               class="btn btn-sm {{ ($branch_id ?? 0) == $branch->id ? 'btn-primary' : 'btn-outline-secondary' }}">Branch {{ $branch->id }}</a>
        @endforeach
    </div>
</nav>

<table class="table table-striped table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Content</th>
        <th>Action</th>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
        <td><a href="{{ $path }}/items/add/">Create</a></td>
    </tr>
    @foreach($items as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->title }}</td>
            <td>{{ $item->content }}</td>
            <td><a href="{{ $path }}/items/{{ $item->id }}/edit/">Edit</a></td>
        </tr>
    @endforeach
</table>
</body>
</html>
