<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config("app.name", "Josh Whitwell") }}</title>
    @vite(['resources/css/joshwhitwell.css'])
  </head>
  <body>
    <x-blobs />
  </body>
</html>
