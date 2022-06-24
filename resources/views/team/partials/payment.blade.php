<div class="pt-5">
    <div class="card-body">
        <form method="POST" action="" class="form-horizontal">
            @csrf
            @method('PUT')

            <input type="submit" id="user-password-submit" class="d-none">
        </form>
    </div>
    <div class="card-footer d-flex">
        <label for="user-password-submit" class="btn btn-labeled btn-common ml-auto mb-0">
            <span class="btn-label"></span>{{ __('Save') }}
        </label>
    </div>
</div>