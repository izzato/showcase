<x-guest-layout>
    <x-slot name="title">{{ __('Set new password') }}</x-slot>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <a href="/" class="d-flex justify-content-center mb-5">
                    <x-application-logo class="w-25" />
                </a>
                <div class="card card-shadow">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Set new password') }}</h4>
                    </div>
                    <div class="card-body pt-0">
                        <x-auth-session-status class="mb-4 alert alert-info" :status="session('status')" />

                        <form method="POST" action="{{ route('password.update') }}" class="form-horizontal">
                            @csrf
                            <input type="hidden" name="token" value="{{ request()->route('token') }}">
                            <div class="form-group">
                                <label for="email">{{ __('Email') }}</label>
                                <input class="form-control" type="text" required="required" id="email"
                                       name="email" value="{{ old('email', request()->email) }}" readonly="readonly">
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input class="form-control" type="password" id="password" required="required" autofocus="autofocus"
                                       name="password" autocomplete="new-password">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation" class="text-capitalize-sentence">
                                    {{ __('Confirm Password') }}
                                </label>
                                <input class="form-control" type="password" id="password_confirmation" required="required"
                                       name="password_confirmation" autocomplete="new-password">
                            </div>
                            <div class="form-group text-center mb-0">
                                <button class="btn btn-common btn-block btn-feature" type="submit">
                                    {{ __('Set new password') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>