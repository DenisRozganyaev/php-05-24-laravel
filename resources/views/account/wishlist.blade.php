@extends('layouts.account')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5 text-center">
                <h3>Categories</h3>
            </div>
            <div class="col-12">
                <hr>
            </div>
            <div class="col-12 mt-5">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Image</th>
                        <th>@sortablelink('title', 'Title')</th>
                        <th>@sortablelink('price', 'Price')</th>
                        <th>In stock?</th>
                        <th>Follow Price</th>
                        <th>Follow Exist</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($wishes as $item)
                        <tr>
                            <td>
                                <img src="{{$item->thumbnailUrl}}" alt="{{$item->title}}" width="35" height="50" />
                            </td>
                            <td><a href="{{route('products.show', $item)}}" class="link-info">{{$item->title}}</a></td>
                            <td>{{$item->finalPrice}} $</td>
                            <td>
                                @if ($item->exist)
                                    <i class="fa-regular fa-circle-check text-success"></i>
                                @else
                                    <i class="fa-regular fa-circle-xmark text-danger"></i>
                                @endif
                            </td>
                            <td>
                                @include(
                                    'products.parts.wishlist.price',
                                    [
                                        'product' => $item,
                                        'isFollowed' => auth()->user()->isWishedProduct($item),
                                        'mini' => true
                                    ]
                                )
                            </td>
                            <td>
                                @include(
                                    'products.parts.wishlist.exist',
                                    [
                                        'product' => $item,
                                        'isFollowed' => auth()->user()->isWishedProduct($item, 'exist'),
                                        'mini' => true
                                    ]
                                )
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $wishes->links() }}
            </div>
        </div>
    </div>
@endsection
