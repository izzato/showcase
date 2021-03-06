<x-guest-layout>
    <x-slot name="title">{{ __('Confirm code') }}</x-slot>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <a href="/" class="d-flex justify-content-center mb-5">
                    <x-application-logo class="w-25" />
                </a>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        <strong><i class="fa fa-check mr-2"></i> {{session('status')}}</strong>
                    </div>
                @endif

                <div class="card card-shadow">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Confirm code') }}</h4>
                    </div>
                    <div class="card-body pt-0">
                        <x-auth-session-status class="mb-4 alert alert-info" :status="session('status')" />

                        <p>
                            @if (request()->get('use-recovery-code'))
                                {{ __('Please confirm a recovery code to continue.') }}
                            @else
                                {{ __('Please confirm a code from your authenticator app to continue.') }}
                            @endif
                        </p>

                        <form method="POST" action="{{ url('two-factor-challenge') }}{{ request()->has('use-recovery-code') ? '?use-recovery-code=true' : '' }}" class="form-horizontal">
                            @csrf
                            <div class="form-group">
                                @if (request()->get('use-recovery-code'))
                                    <label for="code">{{ __('Recovery code') }}</label>
                                    <a href="{{url('two-factor-challenge')}}" class="float-right">
                                        {{ __('Use authentication code') }}
                                    </a>
                                    <input class="form-control @error('recovery_code') is-invalid @enderror" type="text"
                                           required="required" autofocus="autofocus" id="code" name="recovery_code"
                                           value="" autocomplete="off">
                                    @error('recovery_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @else
                                    <label for="code">{{ __('Two factor code') }}</label>
                                    <a href="{{url('two-factor-challenge')}}?use-recovery-code=true"
                                       class="float-right">{{ __('Use recovery code') }}</a>
                                    <input class="form-control @error('code') is-invalid @enderror" type="text"
                                           required="required" autofocus="autofocus" id="code" inputmode="numeric" pattern="[0-9]*" name="code"
                                           value="" autocomplete="off">
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @endif
                            </div>

{{--                            @if (!request()->get('use-recovery-code'))--}}
{{--                            <div class="form-group">--}}
{{--                                <div class="custom-control custom-checkbox">--}}
{{--                                    <input type="checkbox" class="custom-control-input" id="remember_2fa" name="remember">--}}
{{--                                    <label class="custom-control-label" for="remember_2fa" dusk="remember-device">--}}
{{--                                        {{ __('Remember device for 30 days') }}--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            @endif--}}

                            <div class="form-group text-center mb-0">
                                <button class="btn btn-common btn-block btn-feature" type="submit">
                                    {{ __('Confirm') }}
                                </button>
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