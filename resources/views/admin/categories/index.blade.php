@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 pt-5">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Parent</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{$category->id}}</td>
                            <td>{{$category->name}}</td>
                            <td>{{$category->parent?->name ?? '-'}}</td>
                            <td>{{$category->created_at}}</td>
                            <td>{{$category->updated_at}}</td>
                            <td>
                                <form action="{{route('admin.categories.destroy', $category)}}" method="POST" class="btn-group" role="group" aria-label="Basic example">
                                    @csrf
                                    @method('DELETE')
                                    <a type="button" href="{{route('admin.categories.edit', $category)}}" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $categories->links() }}
            </div>
        </div>
    </div>
@endsection
