<!DOCTYPE html>
<html ang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Conferma del pagamento {{ config('app.name') }}</title>
    <style>
        * , body{
            box-sizing: border-box;
            display: block;
            content: "";
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .wrapper {
            min-height: 100vh;
            min-width: 100vw;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        .logo {
            position: absolute;
            z-index: 1;
            filter: blur(6px) opacity(0.7);
            height: 100%;
            width: 100%;
            object-fit: cover;
        }
        .bolder {
            font-weight: bold
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="wrapper">
            <img src="https://i.ibb.co/tL8yFQy/Loghi-Finetti-def-1.png" alt="Loghi-Finetti-def-1" class="img-logo"/>
            <div style=" position: absolute; z-index: 2; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                <h1>
                    Ciao! {{$data['customer']['first_name']}} {{ $data['customer']['last_name'] }}
                </h1>
                <h4>
                    Grazie per aver prenotato il tuo spettacolo a Villa Albertina
                </h4>
                <h5 >
                    Se avessi dubbi e/o domande, non esitare a contattarci ;
                </h5>
                <h5 class="bolder">
                    👶 Lo STAFF di {{ config('app.name') }} 👶
                </h5>
            </div>
        </div>
    </div>
</body>
</html>
