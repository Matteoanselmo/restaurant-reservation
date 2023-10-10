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
            Ciao! {{$data['customer']['first_name']}} {{ $data['customer']['last_name'] }}
            </h1>
            <h3>
            La prenotazione per {{ $data['data']['pranzoOCena'] }} del {{ $data['data']['data'] }} è andata a buon fine
            </h3>
            <h4 style="font-family: 'Noto Serif Display', serif;">
            Grazie per aver prenotato il tuo show a Villa Albertina 🏠
            </h4>
            <h5 style="font-family: 'Noto Serif Display', serif; margin-bottom: 10px;">
            Se avessi dubbi e/o domande, non esitare a contattarci ;
            </h5>
            <table>
                <tr>
                    <th>
                        Prenotato
                    </th>
                    <th>
                        Contatto
                    </th>
                    <th>
                        Prezzo
                    </th>
                </tr>
                @foreach ($data['booked'] as $customerData)
                    <tr>
                        <td>{{ $customerData['nome'] }} {{ $customerData['cognome'] }}</td>
                        <td>{{$customerData['email']}}</td>
                        <td>&euro; {{$customerData['price']}}</td>
                    </tr>
                @endforeach
            </table>
            <div style="font-family: 'Berkshire Swash', cursive;">
                👨‍🍳 Lo STAFF di {{ config('app.name') }} 👨‍🍳
            </div>

        </div>
    </div>
</body>
</html>
