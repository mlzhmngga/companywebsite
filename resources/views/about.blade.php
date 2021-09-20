<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>About | Company Name</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />

</head>

<body>
    {{ view('nbar',  ['baseUrl' => env('BASE_URL')]) }}

    <div class="m-3">
        <h1>About us</h1>
    </div>

    <hr />

    <div class="m-3">
        <h5>Contact Person</h5>
        <div>Phone: +62818-9283-1829</div>
        <div>Address: Junior st. Indonesia 15562</div>
        <div>Email: companya@gmail.com</div>
        
    </div>
</body>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>


</html>