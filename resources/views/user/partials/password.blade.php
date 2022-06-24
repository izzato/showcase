<div class="pt-5">
    <div class="card-body">
        <form method="POST" action="{{ route('user-password.update') }}" class="form-horizontal">
            @csrf
            @method('PUT')
            <div class="form-group password-show-toggle">
                <label for="current_password">{{ __('Current password') }}</label>
                <input class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" type="password" id="current_password"
                       name="current_password" autocomplete="current-password" required="required">
                <a href="#" class="text-muted toggle-btn" tabindex="-1">
                    <i data-hide-class="fa fa-eye-slash" data-show-class="fa fa-eye" aria-hidden="true"
                       data-hide-text="{{ __('Hide password') }}" data-show-text="{{ __('Show password') }}" data-input-id="current_password"></i>
                </a>
                <x-form-group-validation for="current_password" bag="updatePassword" />
            </div>
            <div class="form-group password-show-toggle">
                <label for="new_password">{{ __('New password') }}</label>
                <input class="form-control @error('password', 'updatePassword') is-invalid @enderror" type="password"
                       id="new_password" required="required" name="password" autocomplete="new-password">
                <a href="#" class="text-muted toggle-btn" tabindex="-1">
                    <i data-hide-class="fa fa-eye-slash" data-show-class="fa fa-eye" aria-hidden="true"
                       data-hide-text="{{ __('Hide password') }}" data-show-text="{{ __('Show password') }}"></i>
                </a>
                <x-form-group-validation for="password" bag="updatePassword" />
            </div>
            <div class="form-group password-show-toggle">
                <label for="password_confirmation" class="text-capitalize-sentence">{{ __('Confirm Password') }}</label>
                <input class="form-control" type="password" id="password_confirmation"
                       required="required" name="password_confirmation" autocomplete="new-password">
                <a href="#" class="text-muted toggle-btn" tabindex="-1">
                    <i data-hide-class="fa fa-eye-slash" data-show-class="fa fa-eye" aria-hidden="true"
                       data-hide-text="{{ __('Hide password') }}" data-show-text="{{ __('Show password') }}" data-input-id="password_confirmation"></i>
                </a>
            </div>
            <input type="submit" id="user-password-submit" class="d-none">
        </form>
    </div>
    <div class="card-footer d-flex">
        <label for="user-password-submit" class="btn btn-labeled btn-common ml-auto mb-0">
            <span class="btn-label"></span>{{ __('Save') }}
        </label>
    </div>
</div>