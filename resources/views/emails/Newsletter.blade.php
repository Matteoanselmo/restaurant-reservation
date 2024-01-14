<!DOCTYPE html>
<html ang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Conferma del pagamento {{ config('app.name') }}</title>
    @vite(['resources/scss/app.scss' ,'resources/js/app.js'])
</head>
<body>
    <div style="background-color: white;">
        <div style="text-align: center; padding: 20px;">
            <img src="https://i.ibb.co/tL8yFQy/Loghi-Finetti-def-1.png" alt="Loghi-Finetti-def-1" class="img-logo"/>
        </div>
        <div style="text-align: center; color: black; padding: 20px; background-color: white;">
            <h1 style="font-family: 'Berkshire Swash', cursive; color: black;">
            Villa Albertina News
            </h1>
            <h3>
                {!! $messages !!}
            </h3>
            <div style="font-family: 'Berkshire Swash', cursive;">
                👨‍🍳 Lo STAFF di {{ config('app.name') }} 👨‍🍳
            </div>
        </div>
    </div>
</body>
</html>
