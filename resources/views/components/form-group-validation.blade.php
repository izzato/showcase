@props(['for', 'bag' => 'default'])

@error($for, $bag)
<div class="invalid-feedback">{{ $message }}</div>
@enderror