<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <a href="/" class="d-flex justify-content-center mb-5">
                    <x-application-logo style="width: 50px;"/>
                </a>
                <div class="card card-shadow">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Verify your email') }}</h4>
                    </div>
                    <div class="card-body pt-0">
                        @if (session('status') == 'verification-link-sent')
                            <p class="text-success">
                                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                            </p>
                        @else
                            <p>
                                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                            </p>
                        @endif

                        <form method="POST" action="{{ route('verification.send') }}" class="form-horizontal">
                            @csrf
                            <div class="form-group text-center mb-0">
                                <button class="btn btn-common btn-block btn-feature"
                                        type="submit" {{ session('status') !== 'verification-link-sent'?: 'disabled' }}>{{ __('Resend verification email') }}</button>
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