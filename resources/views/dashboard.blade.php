<x-app-layout>
    <x-slot name="title">{{ __('Dashboard') }}</x-slot>
    <x-slot name="header">
        <div class="container-fluid">
            <div class="breadcrumb-wrapper row">
                <div class="col-12 col-lg-3 col-md-6">
                    <h4 class="page-title">{{ __('Dashboard') }}</h4>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="container">
        <div class="col-lg-12 col-md-12 col-xs-12">
            <x-auth-session-status class="mb-4 alert alert-info" :status="session('status')" />

            <div class="card {{ session('theme') === 'dark' ? 'bg-dark' : '' }}">
                <h2 class="card-header">
                    {{ __('Hello!') }}
                    {{ __('Welcome back!') }}
                </h2>
                <div class="card-body"></div>
            </div>
        </div>
    </div>
</x-app-layout>
