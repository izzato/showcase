<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <a href="/" class="d-flex justify-content-center mb-5">
                    <x-application-logo style="width: 50px;"/>
                </a>
                <div class="card card-shadow">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Set a new password') }}</h4>
                    </div>
                    <div class="card-body pt-0">
                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')"/>

                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

                        <form method="POST" action="{{ route('password.update') }}" class="form-horizontal">
                            @csrf

                            <input type="hidden" name="token" value="{{ request()->route('token') }}">

                            <div class="form-group">
                                <label for="email">{{ __('Email') }}</label>
                                <input class="form-control" type="text" required="" id="email" tabindex="1"
                                       name="email" value="{{ old('email', request()->email) }}" readonly="">
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input class="form-control" type="password" id="password" required="" tabindex="2"  autofocus="" name="password" autocomplete="new-password">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">{{ __('Confirm password') }}</label>
                                <input class="form-control" type="password" id="password_confirmation" required="" tabindex="3"
                                       name="password_confirmation" autocomplete="new-password">
                            </div>
                            <div class="form-group text-center mb-0">
                                <button class="btn btn-common btn-block" type="submit" tabindex="4">{{ __('Set new password') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>