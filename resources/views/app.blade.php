<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title inertia>{{ config('app.name', 'BoolBnb') }}</title>

  <!-- Fonts -->
  <link rel="stylesheet"
    href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.css'
    integrity='sha512-+ouAqATs1y4kpPMCHfKHVJwf308zo+tC9dlEYK9rKe7kiP35NiP+Oi35rCFnc16zdvk9aBkDUtEO3tIPl0xN5w=='
    crossorigin='anonymous' />

  {{-- tomtom --}}
  <link rel="stylesheet" type="text/css"
    href="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.23.0/maps/maps.css" />

  {{-- BrainTree --}}
  <script src="https://js.braintreegateway.com/web/dropin/1.34.0/js/dropin.min.js"></script>


  <!-- Scripts -->
  @routes
  @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
  @inertiaHead
</head>

<body class="font-sans antialiased">
  @inertia
</body>

</html>
