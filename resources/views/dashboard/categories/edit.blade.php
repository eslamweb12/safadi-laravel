@extends('layouts.dashboard')

@section('title', 'Edit Category')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Categories</li>
<li class="breadcrumb-item active">Edit Categoriey</li>
@endsection

@section('content')
<form action="{{route('dashboard.categories.update',$category->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    @include('dashboard.categories._form')
</form>

@endsection