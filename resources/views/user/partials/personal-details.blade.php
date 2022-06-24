<div class="pt-5">
    <div class="card-body">
        <form method="POST" action="{{ route('verification.send') }}" class="d-none">
            @csrf
            <button type="submit" id="verification-btn"></button>
        </form>
        <form method="POST" action="{{ route('user-profile-information.update') }}" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <div class="d-none">
                    <input type="file" class="custom-file-input" id="photo" name="photo" onchange="updatePhotoPreview()">
                </div>
                <label>
                    {{ __('Photo') }}
                </label>
                <div class="my-2 profile-img">
                    <img src="{{ auth()->user()->profilePhotoUrl }}" alt="{{ auth()->user()->name }}"
                         class="rounded-circle"
                         id="current-photo">
                    <span
                        id="photo-preview"
                        class="rounded-circle"
                        style="display: none"
                    ></span>
                </div>
                <label for="photo" class="btn btn-outline-secondary @error('photo', 'updateProfileInformation') is-invalid @enderror">{{ __('Select a new photo') }}</label>

                <x-form-group-validation for="photo" bag="updateProfileInformation" />
            </div>
            <div class="form-group">
                <label for="name">{{ __('Name') }}</label>
                <input class="form-control @error('name', 'updateProfileInformation') is-invalid @enderror" type="text"
                       required="required" id="name" name="name"
                       value="{{ old('name', auth()->user()->name) }}">
                <x-form-group-validation for="name" bag="updateProfileInformation" />
            </div>
            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <input class="form-control @error('email', 'updateProfileInformation') is-invalid @enderror" type="email"
                       required="required" id="email" name="email" value="{{ old('email', auth()->user()->email) }}">
                <x-form-group-validation for="email" bag="updateProfileInformation" />
                @if (!auth()->user()->email_verified_at)
                <p class="text-sm mt-2">{{ __('Your email address is unverified.') }}
                    <label for="verification-btn" class="btn btn-link p-0 m-0 border-0" style="vertical-align: baseline">{{ __('Click here to re-send the verification email.') }}</label>
                </p>
                @endif
            </div>
            <div class="form-group">
                <label for="timezone">{{ __('Timezone') }}</label>
                <select class="form-control @error('timezone', 'updateProfileInformation') is-invalid @enderror"
                        id="timezone" required="required" name="timezone">
                    <option>{{ __('Select an option') }}</option>
                    @foreach(Symfony\Component\Intl\Timezones::getNames() as $key => $value)
                        <option {{ old('timezone', auth()->user()->settings()->get('timezone')) === $key ? 'selected' : '' }} value="{{ $key }}">
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
                <x-form-group-validation for="timezone" bag="updateProfileInformation" />
            </div>
            <div class="form-group">
                <label for="locale">{{ __('Language') }}</label>
                <x-locale-selector for="locale" />
                <x-form-group-validation for="locale" bag="updateProfileInformation" />
            </div>
            <div class="form-group">
                <label for="theme">{{ __('Theme') }}</label>
                <select class="form-control @error('theme', 'updateProfileInformation') is-invalid @enderror"
                        id="theme" required="required" name="theme">
                    <option {{ old('theme', auth()->user()->settings()->get('theme')) === 'auto' ? 'selected' : '' }} value="auto">
                        {{ __('System default') }}
                    </option>
                    <option {{ old('theme', auth()->user()->settings()->get('theme')) === 'light' ? 'selected' : '' }} value="light">
                        {{ __('Light') }}
                    </option>
                    <option {{ old('theme', auth()->user()->settings()->get('theme')) === 'dark' ? 'selected' : '' }} value="dark">
                        {{ __('Dark') }}
                    </option>
                </select>
                <x-form-group-validation for="theme" bag="updateProfileInformation" />
            </div>
            <input type="submit" id="user-personal-details-submit" class="d-none">
        </form>
    </div>
    <div class="card-footer d-flex">
        <label for="user-personal-details-submit" class="btn btn-labeled btn-common ml-auto mb-0">
            <span class="btn-label"></span>{{ __('Save') }}
        </label>
    </div>
</div>