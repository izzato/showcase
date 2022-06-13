<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <a href="/" class="d-flex justify-content-center mb-5">
                    <x-application-logo style="width: 50px;"/>
                </a>
                <div class="card card-shadow">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Reset your password') }}</h4>
                    </div>
                    <div class="card-body pt-0">
                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')"/>

                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

                        <p>
                            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                        </p>

                        <form method="POST" action="{{ route('password.email') }}" class="form-horizontal">
                            @csrf
                            <div class="form-group">
                                <label for="email">{{ __('Email') }}</label>
                                <input class="form-control" type="text" required="" id="email" autofocus="" name="email"
                                       value="{{ old('email') }}">
                            </div>
                            <div class="form-group text-center mb-0">
                                <button class="btn btn-common btn-block"
                                        type="submit">{{ __('Email password reset link') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="form-group text-center">
                    <a href="{{ route('login') }}">{{ __('Sign in') }}</a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>