<div class="pt-5">
    <div class="card-body">
        <form method="POST" action="" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">{{ __('Name') }}</label>
                <input class="form-control @error('name', 'updateTeamInformation') is-invalid @enderror" type="text"
                       required="required" id="name" name="name"
                       value="{{ old('name', '<Team name>') }}">
                <x-form-group-validation for="name" bag="updateTeamInformation" />
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