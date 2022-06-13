<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <a href="/" class="d-flex justify-content-center mb-5">
                    <x-application-logo style="width: 50px;"/>
                </a>
                <div class="card card-shadow">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Create an account') }}</h4>
                    </div>
                    <div class="card-body pt-0">
                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')"/>

                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

                        <form method="POST" action="{{ route('register') }}" class="form-horizontal">
                            @csrf
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input class="form-control" type="text" required="" id="name" autofocus="" name="name"
                                       value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('Email') }}</label>
                                <input class="form-control" type="text" required="" id="email" name="email"
                                       value="{{ old('email') }}">
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input class="form-control" type="password" id="password" required="" name="password"
                                       autocomplete="new-password">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">{{ __('Confirm password') }}</label>
                                <input class="form-control" type="password" id="password_confirmation" required=""
                                       name="password_confirmation" autocomplete="new-password">
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="remember_me"
                                           name="remember">
                                    <label class="custom-control-label"
                                           for="remember_me">{{ __('Agree to terms and conditions') }}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <!-- @captcha -->
                                <div class="h-captcha" data-sitekey="{{ config('services.captcha.key') }}"></div>
                            </div>
                            <div class="form-group text-center mb-0">
                                <button class="btn btn-common btn-block"
                                        type="submit">{{ __('Create account') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="form-group text-center">
                    {{ __("Already have an account?") }} <a href="{{ route('login') }}">{{ __('Sign in') }}</a>
                </div>
            </div>
        </div>
    </div>
    <!-- @captcha_script -->
    <script src="https://js.hcaptcha.com/1/api.js" async defer></script>
</x-guest-layout>