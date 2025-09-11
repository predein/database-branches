<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <script src="{{ asset('js/bootstrap.js') }}" defer></script>

</head>
<body>

<a href="{{ url('/switch?branch_id=0') }}">Main</a>
@foreach($branches as $branch)
    | <a href="{{ url('/switch?branch_id=') }}{{$branch->id}}">Branch {{$branch->id}}</a>
@endforeach

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
