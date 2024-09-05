<div class="form-group">category
    <x-form.input label="Role Name" class="form-control-lg" role="input" name="name" :value="$role->name" />
</div>

<fieldset>
    <legend>{{ __('Abilities') }}</legend>

    @foreach (config('abilities') as $ability_code => $ability_name)
    <div class="row mb-2">
        <div class="col-md-6">
            {{ $ability_name }}
        </div>
        <div class="col-md-2">
            <input type="radio" name="abilities[{{ $ability_code }}]" value="allow" checked>
            Allow
        </div>
        <div class="col-md-2">
            <input type="radio" name="abilities[{{ $ability_code }}]" value="deny" >
            Deny
        </div>
        <div class="col-md-2">
            <input type="radio" name="abilities[{{ $ability_code }}]" value="inherit" >
            Inherit
        </div>
    </div>
    @endforeach
</fieldset>

<div class="form-group">
    <button type="submit" class="btn btn-primary">save</button>
</div>