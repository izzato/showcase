<x-guest-layout>
    <x-slot name="title">{{ __('Confirm Password') }}</x-slot>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <a href="/" class="d-flex justify-content-center mb-5">
                    <x-application-logo class="w-25" />
                </a>
                <div class="card card-shadow">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Confirm Password') }}</h4>
                    </div>
                    <div class="card-body pt-0">
                        <x-auth-session-status class="mb-4 alert alert-info" :status="session('status')" />

                        <p>
                            {{ __('Please confirm your password before continuing.') }}
                        </p>

                        <form method="POST" action="{{ route('password.confirm') }}" class="form-horizontal">
                            @csrf
                            <div class="form-group password-show-toggle">
                                <label for="password">{{ __('Password') }}</label>
                                <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" required="required" name="password"
                                       autocomplete="current-password" autofocus="autofocus">
                                <a href="#" class="text-muted toggle-btn" tabindex="-1">
                                    <i data-hide-class="fa fa-eye-slash" data-show-class="fa fa-eye" aria-hidden="true" data-hide-text="{{ __('Hide password') }}" data-show-text="{{ __('Show password') }}"></i>
                                </a>
                                <x-form-group-validation for="password" />
                            </div>
                            <div class="form-group text-center mb-0">
                                <button class="btn btn-common btn-block btn-feature" type="submit">{{ __('Confirm') }}</button>
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