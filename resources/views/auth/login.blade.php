<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <a href="/" class="d-flex justify-content-center mb-5">
                    <x-application-logo style="width: 50px;"/>
                </a>
                <div class="card card-shadow">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Sign in to your account') }}</h4>
                    </div>
                    <div class="card-body pt-0">
                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')"/>

                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

                        <form method="POST" action="{{ route('login') }}" class="form-horizontal">
                            @csrf
                            <div class="form-group">
                                <label for="email">{{ __('Email') }}</label>
                                <input class="form-control" type="text" required="" id="email" autofocus="" tabindex="1"
                                       name="email" value="{{ old('email') ?: 'admin@example.com' }}">
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <a href="{{ route('password.request') }}" class="float-right"
                                   tabindex="3">{{ __('Forgot your password?') }}</a>
                                <input class="form-control" type="password" id="password" required="" tabindex="2"
                                       name="password" autocomplete="current-password" value="password">
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="remember_me" name="remember"
                                           tabindex="4">
                                    <label class="custom-control-label"
                                           for="remember_me">{{ __('Stay signed in for a week') }}</label>
                                </div>
                            </div>
                            <div class="form-group text-center mb-0" tabindex="5">
                                <button class="btn btn-common btn-block" type="submit">{{ __('Continue') }}</button>
                            </div>
                        </form>
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
