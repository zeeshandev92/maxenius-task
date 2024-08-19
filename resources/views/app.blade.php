<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @vite('resources/js/app.js')
  @inertiaHead
</head>

<body>

  @inertia
  <input type="hidden" value="{{ config('shopify-app.api_key') }}" id="apiKey">
  <input type="hidden" value="{{ request('host') }}" id="host">
  <input type="hidden" value="{{ Auth::user()->name }}" id="shopOrigin">
</body>

</html>
