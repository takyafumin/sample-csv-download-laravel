<!DOCTYPE html>
<html>
<head>
    <title>{{ __('リンクリスト') }}</title>
</head>
<body>
    <h1>リンクリスト</h1>
    <ul>
        <li><a href="{{ route('projects.download') }}">download</a></li>
        <li><a href="{{ route('projects.download.logic') }}">download.logic</a></li>
        <li><a href="{{ route('projects.export') }}">export</a></li>
        <li><a href="{{ route('projects.chunk') }}">chunk</a></li>
        <li><a href="{{ route('projects.generator') }}">generator</a></li>
        <li><a href="{{ route('projects.logic') }}">logic</a></li>
    </ul>
</body>
</html>