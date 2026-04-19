<html>
<head>
    <title>Say Hello</title>
</head>
<body>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="/form" method="post">
    <label for="name">
        <input type="text" name="name">
    </label>
    <input type="submit" value="Say Hello">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
</form>
</body>
</html>