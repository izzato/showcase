<x-guest-layout>
    <x-slot name="title">{{ __('Create account') }}</x-slot>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <a href="/" class="d-flex justify-content-center mb-5">
                    <x-application-logo class="w-25" />
                </a>
                <div class="card card-shadow">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Create account') }}</h4>
                    </div>
                    <div class="card-body pt-0">
                        <x-auth-session-status class="mb-4 alert alert-info" :status="session('status')" />

                        <form method="POST" action="{{ route('register') }}" class="form-horizontal">
                            @csrf
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text"
                                       required="required" id="name" autofocus="autofocus" name="name"
                                       value="{{ old('name') }}">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('Email') }}</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email"
                                       required="required" id="email" name="email" value="{{ old('email') }}">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group password-show-toggle">
                                <label for="password">{{ __('Password') }}</label>
                                <input class="form-control @error('password') is-invalid @enderror" type="password"
                                       id="password" required="required" name="password" autocomplete="new-password">
                                <a href="#" class="text-muted toggle-btn" tabindex="-1">
                                    <i data-hide-class="fa fa-eye-slash" data-show-class="fa fa-eye" aria-hidden="true"
                                       data-hide-text="{{ __('Hide password') }}" data-show-text="{{ __('Show password') }}"></i>
                                </a>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group password-show-toggle">
                                <label for="password_confirmation" class="text-capitalize-sentence">{{ __('Confirm Password') }}</label>
                                <input class="form-control" type="password" id="password_confirmation"
                                       required="required" name="password_confirmation" autocomplete="new-password">
                                <a href="#" class="text-muted toggle-btn" tabindex="-1">
                                    <i data-hide-class="fa fa-eye-slash" data-show-class="fa fa-eye" aria-hidden="true"
                                       data-hide-text="{{ __('Hide password') }}" data-show-text="{{ __('Show password') }}"
                                       data-input-id="password_confirmation"></i>
                                </a>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox"
                                           class="custom-control-input @error('agreed_to_terms_and_conditions') is-invalid @enderror"
                                           id="agreed_to_terms_and_conditions" name="agreed_to_terms_and_conditions"
                                           required="required">
                                    <label class="custom-control-label" for="agreed_to_terms_and_conditions">
                                        {{ __('Agree to terms and conditions') }}
                                    </label>
                                    @error('agreed_to_terms_and_conditions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                {{-- @captcha --}}
                                <div class="h-captcha @error('captcha') is-invalid @enderror"
                                     data-sitekey="{{ config('services.captcha.key') }}"></div>

                                @error('captcha')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group text-center mb-0">
                                <button class="btn btn-common btn-block btn-feature" type="submit">
                                    {{ __('Create account') }}
                                </button>
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
</x-guest-layout>