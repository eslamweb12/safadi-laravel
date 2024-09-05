@extends('layouts.dashboard')

@section('title', 'Edit Profile')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Edit Profile</li>
@endsection

@section('content')

<x-alert type="success" />

<form action="{{ route('dashboard.profile.update') }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('patch')
    
    <div class="form-row">
        <div class="col-md-6">
            <x-form.input name="first_name" label="First Name" :value="$user->profile->first_name" />
        </div>
        <div class="col-md-6">
            <x-form.input name="last_name" label="Last Name" :value="$user->profile->last_name" />
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-6">
            <x-form.input name="birthday" type="date" label="Birthday" :value="$user->profile->birthday" />
        </div>
        <div class="col-md-6">
            <x-form.radio name="gender" label="Gender" :options="['male'=>'Male', 'female'=>'Female']" :checked="$user->profile->gender" />
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-4">
            <x-form.input name="street_address" label="Street Address" :value="$user->profile->street_address" />
        </div>
        <div class="col-md-4">
            <x-form.input name="city" label="City" :value="$user->profile->city" />
        </div>
        <div class="col-md-4">
            <x-form.input name="state" label="State" :value="$user->profile->state" />
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-4">
            <x-form.input name="postal_code" label="Postal Code" :value="$user->profile->postal_code" />
        </div>


        <!-- <select name="country" class="form-control mx-2">
            <option value="">Country</option>
            <option value="Egypt" >Egypt</option>
        </select> -->
        <!-- <select name="locale" class="form-control mx-2">
            <option value="">Locale</option>
            <option value="English" >English</option>
        </select> -->
    
    </div>

    <button type="submit" class=" btn btn-primary">Save</button>
</form> 

@endsection