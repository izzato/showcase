<x-app-layout>
    <x-slot name="header">
        <div class="container-fluid">
            <div class="breadcrumb-wrapper row">
                <div class="col-12 col-lg-3 col-md-6">
                    <h4 class="page-title">{{ __('User settings') }}</h4>
                </div>
                <div class="col-12 col-lg-9 col-md-6">
                    <ol class="breadcrumb float-right">
                        <li><a href="/">{{ __('Dashboard') }}</a></li>
                        <li class="active"> / User settings</li>
                    </ol>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="container">
        <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="card">
                <div class="tab-info">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a href="#card-tab-1" class="nav-link" role="tab" data-toggle="tab">Personal details</a>
                        </li>
                        <li class="nav-item">
                            <a href="#card-tab-2" class="nav-link" role="tab" data-toggle="tab">Password</a>
                        </li>
                        <li class="nav-item">
                            <a href="#card-tab-3" class="nav-link active" role="tab" data-toggle="tab">Two-factor authentication</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade" id="card-tab-1">
                            <div class="p-20">
                                <p>Oh, yes, that's very good. I like that. Oh! Something's not right because now I can't
                                    see. Wait. Wait! Oh, my! what have you done? I'm backwards, you stupid furball. Only
                                    an overgrown mophead like you would be stupid enough... I feel terrible. Why are
                                    they doing this? They never even asked me any questions. Lando. Get out of here,
                                    Lando! Shut up and listen! Vader has agreed to turn Leia and Chewie over to me. Over
                                    to you? They'll have to stay here, but at least they'll be safe.</p>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="card-tab-2">
                            <div class="p-20">
                                <p>Rouge Group, use your harpoons and tow cables. Go for the legs. It might be our only
                                    chance of stopping them. All right, stand by, Dack. Luke, we've got a malfunction in
                                    fire control. I'll have to cut in the auxiliary. ust hang on. Hang on, Dack. Get
                                    ready to fire that tow cable. Dack? Dack! Yes, Lord Vader. I've reached the main
                                    power generator. The shield will be down in moments. You may start your landing.
                                    Rouge Three. Copy, Rouge Leader Wedge, I've lost my gunner.You'll have to make this
                                    shot.</p>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane active" id="card-tab-3">
                            <two-factor-authentication enabled="{{!empty(auth()->user()->two_factor_secret)}}"
                                                       show-qr-code-button="{{request()->get('show-qr-code')}}"></two-factor-authentication>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
