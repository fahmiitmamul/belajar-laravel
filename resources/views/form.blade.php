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
    @csrf
    <label>Username : <input type="text" name="username"></label> <br>
    <label>Password : <input type="text" name="username"></label> <br>
</form>
</body>
</html>