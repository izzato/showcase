<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Mulish:wght@400;500;600;700&display=swap">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="app header-default side-nav-light">
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

<script>window.sdx = window.sdx || {};sdx.settings = {"twoFactorAuthentication":{"isEnabled":"Two-factor authentication is currently enabled","isDisabled":"Two-factor authentication is not currently enabled","explanation":"When two-factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's Authenticator application.","enabledScanQrCode":"Please finish configuring two factor authentication by scanning the following QR code using your authenticator application and entering a code.","recoveryCodeExplanation":"Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two-factor authentication device is lost.","regenerateRecoveryCodes":"Regenerate Recovery Codes","showRecoveryCodes":"Show Recovery Codes","showQrCode":"Show QR Code","disable":"Disable two-factor authentication","enable":"Enable two-factor authentication","oldBrowserLeaveWarning":"Two-factor authentication may be enabled, but the process is not finished. Are you sure you wish to leave?","confirmAppCode":"Confirm app code","enterAuthenticatorAppCode":"Please scan this and enter a code from your authentication application.","code":"Code","confirm":"Confirm","sorry":"Sorry","thereWasAnError":"There was an error","codeDoesNotMatch":"This code does not match our records","passwordDoesNotMatch":"This password does not match our records","success":"Success!","cancel":"Cancel","password":"Password","confirmPassword":"Confirm password","pleaseConfirmPassword":"For your security, please confirm your password to continue","recoveryCodesGenerated":"Two-factor recovery codes have been regenerated!","confirmRegeneration":"Confirm Regeneration","pleaseConfirmRegeneration":"Please confirm that two-factor recovery codes should be regenerated","confirmDisable":"Confirm disable","pleaseConfirmDisable":"Please confirm that two-factor authentication should be disabled","hasBeenDisabled":"Two-factor authentication has been disabled!","hasBeenEnabled":"Two-factor authentication has been enabled!","pleaseConfirmAppCode":"Please enter a code from your authentication application or a recovery code to confirm","toggleURL":"\/user\/two-factor-authentication","recoveryCodesURL":"\/user\/two-factor-recovery-codes","disableCheckURL":"\/user\/two-factor-authentication","qrCodeURL":"\/user\/two-factor-qr-code","confirmPasswordURL":"\/user\/confirm-password","confirmedPasswordStatusURL":"\/user\/confirmed-password-status","enableCheckURL":"\/user\/confirmed-two-factor-authentication"}};</script><script>window.sdx = window.sdx || {};sdx.auth = {"user":{"id":{{ auth()->user()->id }},"email":"{{ auth()->user()->email }}","first_name":"{{ auth()->user()->name }}"}};</script>


<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/theme.js') }}"></script>
</body>
</html>