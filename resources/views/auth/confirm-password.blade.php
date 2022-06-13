<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <a href="/" class="d-flex justify-content-center mb-5">
                    <x-application-logo style="width: 50px;"/>
                </a>
                <div class="card card-shadow">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Confirm your password') }}</h4>
                    </div>
                    <div class="card-body pt-0">
                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')"/>

                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

                        <p>
                            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                        </p>

                        <form method="POST" action="{{ route('password.confirm') }}" class="form-horizontal">
                            @csrf
                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input class="form-control" type="password" id="password" required="" name="password"
                                       autocomplete="current-password" autofocus>
                            </div>
                            <div class="form-group text-center mb-0">
                                <button class="btn btn-common btn-block" type="submit">{{ __('Confirm') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="text-center">
                    @csrf

                    <button type="submit" class="btn btn-link text-muted btn-sm">
                        {{ __('Sign out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>