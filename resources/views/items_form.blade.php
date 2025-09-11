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
    <h1>Create Item</h1>
    <form method="POST" action="{{ $action }}">
        <input type="hidden" name="_token" value="{{ $csrf }}">
        <label>Title <input name="title" value="{{ $title }}" required maxlength="255"></label><br>
        <label>Content <textarea name="content">{{ $content }}</textarea></label><br>
        <button type="submit">Save</button>
    </form>
    <p><a href="{{ $path }}">Back to list</a></p>
</body>
</html>
