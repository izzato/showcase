<x-app-layout>
    <x-slot name="title">{{ __('User settings') }}</x-slot>
    <x-slot name="header">
        <div class="container-fluid">
            <div class="breadcrumb-wrapper row">
                <div class="col-12 col-lg-3 col-md-6">
                    <h4 class="page-title">{{ __('User settings') }}</h4>
                </div>
                <div class="col-12 col-lg-9 col-md-6">
                    <ol class="breadcrumb float-right">
                        <li><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="active"> / {{ __('User settings') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="container">
        <div class="col-lg-12 col-md-12 col-xs-12">
            <x-auth-session-status class="mb-4 alert alert-info" :status="session('status')" />

            <div class="card {{ session('theme') === 'dark' ? 'bg-dark' : '' }}">
                <div class="tab-info">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a href="#profile" class="nav-link {{ session()->get('tab') === 'profile' || !session()->has('tab') ? 'active' : '' }}" role="tab" data-toggle="tab">{{ __('Personal details') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="#password" class="nav-link {{ session()->get('tab') === 'password' ? 'active' : '' }}" role="tab" data-toggle="tab">{{ __('Password') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="#two-factor-authentication" class="nav-link {{ session()->get('tab') === 'two-factor-authentication' ? 'active' : '' }}" role="tab" data-toggle="tab">{{ __('Two-factor authentication') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane {{ session()->get('tab') === 'profile' || !session()->has('tab') ? 'active' : 'fade' }}" id="profile">
                            @include('user.partials.personal-details')
                        </div>
                        <div role="tabpanel" class="tab-pane {{ session()->get('tab') === 'password' ? 'active' : 'fade' }}" id="password">
                            @include('user.partials.password')
                        </div>
                        <div role="tabpanel" class="tab-pane {{ session()->get('tab') === 'two-factor-authentication' ? 'active' : 'fade' }}" id="two-factor-authentication">
                            <two-factor-authentication enabled="{{!empty(auth()->user()->two_factor_secret)}}"
                                                       show-qr-code-button="{{request()->get('show-qr-code')}}"></two-factor-authentication>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
