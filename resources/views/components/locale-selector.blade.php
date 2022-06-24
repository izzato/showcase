@props(['for', 'redirect' => false, 'flags' => false])

<select class="form-control @error($for) is-invalid @enderror @if($redirect) js-redirect-onchange @endif"
        id="{{ $for }}" required="required" name="{{ $for }}">
    <option>{{ __('Select an option') }}</option>
    @foreach(cache('languages') as $key => $options)
        <option {{ old($for, app()->getLocale()) === $key ? 'selected' : '' }} value="{{ $key }}">
            {{ $options['name'] }} {{ $flags ? $options['flag'] : '' }}
        </option>
    @endforeach
</select>