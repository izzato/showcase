<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? "$title | " : '' }}{{ config('app.name') }}</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon-196x196.png') }}" sizes="196x196">
    <link rel="icon" type="image/png" href="{{ asset('favicon-96x96.png') }}" sizes="96x96">
    <link rel="icon" type="image/png" href="{{ asset('favicon-32x32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ asset('favicon-16x16.png') }}" sizes="16x16">
    <link rel="icon" type="image/png" href="{{ asset('favicon-128.png') }}" sizes="128x128">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Mulish:wght@400;500;600;700&display=swap">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/' . session('theme') . '.css') }}">
</head>
<body>
<div class="app header-default side-nav-{{ session('theme') }} {{ auth()->user()->settings()->get('sidebar_collapsed') ? 'side-nav-folded' : ''}}">
    <div class="layout">
        @include('partials.navigation')

        @include('partials.left-navigation')

        <div class="page-container">
            <div class="main-content" id="app">
                {{ $header }}

                {{ $slot }}
            </div>

            @include('partials.footer')
        </div>
    </div>
</div>

<x-preloader />

<script>window.old = window.old || {};old.settings = {"twoFactorAuthentication":{"toggleURL":"\/user\/two-factor-authentication","recoveryCodesURL":"\/user\/two-factor-recovery-codes","disableCheckURL":"\/user\/two-factor-authentication","qrCodeURL":"\/user\/two-factor-qr-code","confirmPasswordURL":"\/user\/confirm-password","confirmedPasswordStatusURL":"\/user\/confirmed-password-status","enableCheckURL":"\/user\/confirmed-two-factor-authentication"}};</script>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/theme.js') }}"></script>

<x-app-settings />
</body>
</html>