@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-center pt-5">
                <form class="card w-50" method="POST" action="{{route('admin.categories.store')}}">
                    @csrf

                    <h5 class="card-header">Create category</h5>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Category name"
                                   value="{{ old('name') }}">
                        </div>
                        <div class="mb-3">
                            <label for="parent_id" class="form-label">Parent Category</label>
                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="">No Parent</option>
                                @foreach($categories as $category)
                                    <option
                                        value="{{$category->id}}"
                                        @if(old('parent_id') && old('parent_id') === $categoryid) selected @endif
                                    >{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-end">
                        <button type="submit" class="btn btn-outline-success">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
