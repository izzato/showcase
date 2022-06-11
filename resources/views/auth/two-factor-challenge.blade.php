<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <a href="/" class="d-flex justify-content-center mb-5">
                    <x-application-logo style="width: 50px;"/>
                </a>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        <strong><i class="fa fa-check mr-2"></i>{{session('status')}}</strong>
                    </div>
                @endif

                <div class="card card-shadow">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Confirm 2FA code') }}</h4>
                    </div>
                    <div class="card-body pt-0">
                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')"/>

                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

                        <p>
                            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                        </p>

                        <form method="POST" action="{{ url('two-factor-challenge') }}" class="form-horizontal">
                            @csrf
                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input class="form-control" type="password" id="password" required="" tabindex="1"
                                       name="password" autocomplete="current-password" autofocus>
                            </div>

                            <p>
                        {{request()->get('use-recovery-code') ? __('auth.two_factor_authentication.enter_recovery_code') : __("auth.two_factor_authentication.enter_authentication_code")}}
                    </p>
                    <div class="form-group row mt-4">
                        <label class="col-md-4 control-label text-md-right py-1" for="code">{{request()->get('use-recovery-code') ? __('auth.two_factor_authentication.recovery_code') : __('auth.two_factor_authentication.code')}}</label>
                        <div class="col-md-6">
                            @if (request()->get('use-recovery-code'))
                                <input id="code" type="text" class="form-control" placeholder="{{__('auth.two_factor_authentication.recovery_code')}}" name="recovery_code" value="" required autocomplete="off">
                            @else
                                <input id="code" inputmode="numeric" pattern="[0-9]*" class="form-control" placeholder="{{__('auth.two_factor_authentication.code')}}" name="code" value="" required autocomplete="off">
                            @endif
                            <a class="btn btn-link btn-black pl-0" href="{{url('two-factor-challenge')}}{{request()->get('use-recovery-code') ? '': '?use-recovery-code=true'}}" dusk="use-recovery-code">{{request()->get('use-recovery-code') ? __('auth.two_factor_authentication.use_authentication_code') : __('auth.two_factor_authentication.use_recovery_code')}}</a>
                            @if (!request()->get('use-recovery-code'))
                                <div class="checkbox c-checkbox mt-3"><label dusk="remember-device"><input type="checkbox" name="remember_2fa"><span class="fa fa-check"></span> {{__('auth.two_factor_authentication.remember_device_for', ['days' => config('auth.remember_two_factor_expiry')])}}</label></div>
                            @endif
                        </div>
                    </div>



                            <div class="form-group text-center mb-0">
                                <button class="btn btn-common btn-block" type="submit" tabindex="2">{{ __('Confirm') }}</button>
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