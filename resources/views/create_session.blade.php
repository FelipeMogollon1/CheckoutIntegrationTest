<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>webcheckout</title>
</head>
<body>
<div>
    <h1>Crear session</h1>
    <form action="{{route('create.session')}}" method="POST">
        @csrf
        <input type="text" name="total" id="total">
        <button type="submit">Pagar</button>
    </form>
</div>
</body>
</html>