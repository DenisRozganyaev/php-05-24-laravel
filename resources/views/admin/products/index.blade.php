@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 pt-5">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>@sortablelink('id', 'ID')</th>
                        <th></th>
                        <th>@sortablelink('title', 'Title')</th>
                        <th>@sortablelink('SKU', 'SKU')</th>
                        <th>@sortablelink('price', 'Price')</th>
                        <th>@sortablelink('discount', 'Discount')</th>
                        <th>Categories</th>
                        <th>@sortablelink('quantity', 'Quantity')</th>
                        <th>@sortablelink('created_at', 'Created At')</th>
                        <th>@sortablelink('updated_at', 'Updated At')</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{$product->id}}</td>
                            <td><img src="{{$product->thumbnailUrl}}" alt="{{$product->title}}" width="100px"></td>
                            <td>{{$product->title}}</td>
                            <td>{{$product->SKU}}</td>
                            <td>{{$product->price}}</td>
                            <td>{{$product->discount ?? '-'}}</td>
                            <td>
                                @each('admin/categories/parts/category-link', $product->categories, 'category')
                            </td>
                            <td>{{$product->quantity}}</td>
                            <td>{{$product->created_at}}</td>
                            <td>{{$product->updated_at}}</td>
                            <td>
                                <form action="{{route('admin.products.destroy', $product)}}" method="POST" class="btn-group" role="group" aria-label="Basic example">
                                    @csrf
                                    @method('DELETE')
                                    <a type="button" href="{{route('admin.products.edit', $product)}}" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
