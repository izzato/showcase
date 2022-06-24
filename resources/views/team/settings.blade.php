<x-app-layout>
    <x-slot name="title">{{ __('Team settings') }}</x-slot>
    <x-slot name="header">
        <div class="container-fluid">
            <div class="breadcrumb-wrapper row">
                <div class="col-12 col-lg-3 col-md-6">
                    <h4 class="page-title">{{ __('Team settings') }}</h4>
                </div>
                <div class="col-12 col-lg-9 col-md-6">
                    <ol class="breadcrumb float-right">
                        <li><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="active"> / {{ __('Team settings') }}</li>
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
                            <a href="#general" class="nav-link {{ session()->get('tab') === 'general' || !session()->has('tab') ? 'active' : '' }}" role="tab" data-toggle="tab">{{ __('General') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="#payment" class="nav-link {{ session()->get('tab') === 'payment' ? 'active' : '' }}" role="tab" data-toggle="tab">{{ __('Payment') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane {{ session()->get('tab') === 'general' || !session()->has('tab') ? 'active' : 'fade' }}" id="general">
                            @include('team.partials.general')
                        </div>
                        <div role="tabpanel" class="tab-pane {{ session()->get('tab') === 'payment' ? 'active' : 'fade' }}" id="payment">
                            @include('team.partials.payment')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
