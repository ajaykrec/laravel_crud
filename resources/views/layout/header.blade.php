@php
//====
@endphp
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $meta['title'] ?? '' }}</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="{{ $meta['description'] ?? '' }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/') }}assets/img/favicon.png">   
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,300i,400,400i,600,700,800,900%7CPoppins:300,400,500,600,700,800,900" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('/') }}assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}assets/css/custom.css">
    <!-- jQuery JS -->
    <script src="{{ asset('/') }}assets/js/jquery-3.6.0.min.js"></script>    
</head>
<body>
<div class="wrapp">
