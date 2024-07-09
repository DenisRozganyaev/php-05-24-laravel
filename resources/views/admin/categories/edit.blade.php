@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-center pt-5">
                <form class="card w-50" method="POST" action="{{route('admin.categories.update', $category)}}">
                    @csrf
                    @method('PUT')

                    <h5 class="card-header">Edit category</h5>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Category name"
                                   value="{{ old('name') ?? $category->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="parent_id" class="form-label">Parent Category</label>
                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="">No Parent</option>
                                @foreach($categories as $cat)
                                    <option
                                        value="{{$cat->id}}"
                                        @if(old('parent_id') && old('parent_id') === $cat->id) selected @endif
                                        @if($category->parent_id && $category->parent_id === $cat->id) selected @endif
                                    >{{$cat->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-end">
                        <button type="submit" class="btn btn-outline-success">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
