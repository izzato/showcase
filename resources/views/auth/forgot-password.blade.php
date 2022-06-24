<x-guest-layout>
    <x-slot name="title">{{ __('Reset password') }}</x-slot>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <a href="/" class="d-flex justify-content-center mb-5">
                    <x-application-logo class="w-25" />
                </a>
                <div class="card card-shadow">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Reset password') }}</h4>
                    </div>
                    <div class="card-body pt-0">
                        <x-auth-session-status class="mb-4 alert alert-info" :status="session('status')" />

                        <p>
                            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                        </p>

                        <form method="POST" action="{{ route('password.email') }}" class="form-horizontal">
                            @csrf
                            <div class="form-group">
                                <label for="email">{{ __('Email') }}</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="text" required="required" id="email" autofocus="autofocus" name="email"
                                       value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group text-center mb-0">
                                <button class="btn btn-common btn-block btn-feature" type="submit" {{ is_null(session('status')) ? '' : 'disabled' }}>
                                    {{ __('Email password reset link') }}
                                </button>
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