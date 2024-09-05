@extends('layouts.dashboard')

@section('title', 'Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')
<div class="mb-5">
    @if(Auth::user()->can('categories.create'))
      <a href="{{ route('dashboard.categories.create') }}" class="btn btn-sm btn-outline-primary mr-2">Create</a>
      @endif
<a href="{{ route('dashboard.categories.trash') }}" class="btn btn-sm btn-outline-dark">Trash</a>
</div>
  <x-alert type="success"/>
  <x-alert type="info"/>
  <form action="{{URL::current()}}" method="get" class="d-flex justify-content-between mb-4">
    <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')"/>
        <select name="status" class="form-control mx-2">
            <option value="">all</option>
            <option value="active" @selected(request('status')=='active')>Active</option>
            <option value="active" @selected(request('status')=='Archived')>Archived</option>
        </select>
        <button class=" btn btn-dark">Filter</button>



  </form>
<table class="table">
    <thead>
        <tr>
            <th> </th>
            <th>ID</th>
            <th>Name</th>
            <th>Parent</th>
            <th>Products #</th>
            <th>Status</th>
            <th>Created At</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        
           @forelse($categories as $category)
        <tr>
            <td><img src="{{asset ('storage/' . $category->image)}}" alt=""height="50"> </td>
            <td>{{$category->id }}</td>
            <td><a href="{{route('dashboard.categories.show',$category->id)}}"{{$category->name }}</a></td>
            <td>{{$category->parent->name}}</td>
            <td>{{$category->products_number}}</td>    
            <td>{{$category->status}}</td>
            <td>{{$category->created_at }}</td>
            <td>
                @can('categories.update') 
                 <a href="{{route('dashboard.categories.edit',$category->id)}}" class="btn btn-sm btn-outline-success"> Eidt</a>
                @endcan
            </td>
            <td>
            @can('categories.delete') 
                <form action="{{route('dashboard.categories.destroy',$category->id)}}" method="post">
                    @csrf
                    <!-- form method spoofing -->
                    <!-- <input type="hidden"name="method" value="delete"> -->
                    @method('delete')
                    <button type="submit"class="btn btn-sm btn-outline-danger"> Delete</button>
                </form>
            @endcan    
            </td>
        </tr>
        @empty
         <tr> 
             <td colspan="9">No categories founded</td>
        </tr>
         @endforelse
      
       
      

    </tbody>
</table>
{{ $categories->withQueryString()->appends(['search' => 1])->links() }}
 
@endsection