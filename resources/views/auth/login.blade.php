<x-guest-layout>
    <x-slot name="title">{{ __('Sign in') }}</x-slot>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <a href="/" class="d-flex justify-content-center mb-5">
                    <x-application-logo class="w-25" />
                </a>
                <div class="card card-shadow">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Sign in to your account') }}</h4>
                    </div>
                    <div class="card-body pt-0">
                        <x-auth-session-status class="mb-4 alert alert-info" :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}" class="form-horizontal">
                            @csrf
                            <div class="form-group">
                                <label for="email">{{ __('Email') }}</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" autofocus="autofocus"
                                       name="email" value="{{ old('email') }}" required="required">
                                <x-form-group-validation for="email" />
                            </div>
                            <div class="form-group password-show-toggle">
                                <label for="password">{{ __('Password') }}</label>
                                <a href="{{ route('password.request') }}" class="float-right text-capitalize-sentence" tabindex="10">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                                <input class="form-control @error('password') is-invalid @enderror" type="password" id="password"
                                       name="password" autocomplete="current-password" required="required">
                                <a href="#" class="text-muted toggle-btn" tabindex="-1">
                                    <i data-hide-class="fa fa-eye-slash" data-show-class="fa fa-eye" aria-hidden="true" data-hide-text="{{ __('Hide password') }}" data-show-text="{{ __('Show password') }}"></i>
                                </a>
                                <x-form-group-validation for="password" />
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="remember_me"
                                           name="remember">
                                    <label class="custom-control-label" for="remember_me">
                                        {{ __('Stay signed in for :period', ['period' => __('a week')]) }}
                                    </label>
                                </div>
                            </div>
                            <div class="form-group text-center mb-0">
                                <button class="btn btn-common btn-block btn-feature" type="submit">
                                    {{ __('Continue') }}
                                </button>
                            </div>
                        </form>
                        @env('local')
                        <div class="form-group text-center mb-0">
                            <x-login-link email="admin@example.com" label="Login as admin"
                                          class="btn btn-outline-secondary btn-block mt-2 btn-feature"
                                          redirect-url="{{ route('dashboard') }}" />
                            <x-login-link email="user@example.com" label="Login as regular user"
                                          class="btn btn-outline-secondary btn-block mt-2 btn-feature"
                                          redirect-url="{{ route('dashboard') }}" />
                        </div>
                        @endenv
                    </div>
                </div>
                @if (Route::has('register'))
                    <div class="form-group text-center">
                        {{ __("Don't have an account?") }} <a href="{{ route('register') }}">{{ __('Sign up') }}</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-guest-layout>
