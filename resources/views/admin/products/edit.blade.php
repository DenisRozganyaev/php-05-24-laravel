@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-center pt-5">
                <form class="card w-50" method="POST" enctype="multipart/form-data" action="{{route('admin.products.update', $product)}}">
                    @method('PUT')
                    @csrf

                    <h5 class="card-header">Edit product</h5>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('Title') }}</label>

                            <div class="col-md-6">
                                <input id="title" type="text"
                                       class="form-control @error('title') is-invalid @enderror" name="title"
                                       value="{{ old('title') ?? $product->title }}" required autofocus>

                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="SKU" class="col-md-4 col-form-label text-md-end">{{ __('SKU') }}</label>

                            <div class="col-md-6">
                                <input id="SKU" type="text"
                                       class="form-control @error('SKU') is-invalid @enderror" name="SKU"
                                       value="{{ old('SKU') ?? $product->SKU }}" required>

                                @error('SKU')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="description"
                                   class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                    <textarea id="description" type="text"
                                              class="form-control" name="description"
                                    >{{ old('description') ?? $product->description }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="categories"
                                   class="col-md-4 col-form-label text-md-end">{{ __('Categories') }}</label>

                            <div class="col-md-6">
                                <select name="categories[]" id="categories"
                                        class="form-control @error('categories') is-invalid @enderror" multiple>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}"
                                        @if (in_array($category->id, $productCategories)) selected @endif
                                        >{{$category->name}}</option>
                                    @endforeach
                                </select>

                                @error('categories')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="price" class="col-md-4 col-form-label text-md-end">{{ __('Price') }}</label>

                            <div class="col-md-6">
                                <input id="price" type="number"
                                       class="form-control @error('price') is-invalid @enderror" name="price"
                                       value="{{ old('price') ?? $product->price }}"
                                       step="any"
                                       required>

                                @error('price')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="discount"
                                   class="col-md-4 col-form-label text-md-end">{{ __('Discount') }}</label>

                            <div class="col-md-6">
                                <input id="discount" type="number"
                                       class="form-control @error('discount') is-invalid @enderror" name="discount"
                                       value="{{ old('discount') ?? $product->discount }}"
                                       step="any"
                                       min="0"
                                       max="99"
                                       required>

                                @error('discount')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="quantity"
                                   class="col-md-4 col-form-label text-md-end">{{ __('Quantity') }}</label>

                            <div class="col-md-6">
                                <input id="quantity" type="number"
                                       class="form-control @error('quantity') is-invalid @enderror" name="quantity"
                                       value="{{ old('quantity') ?? $product->quantity }}">

                                @error('quantity')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="thumbnail"
                                   class="col-md-4 col-form-label text-md-end">{{ __('Thumbnail') }}</label>

                            <div class="col-md-12 mb-4 d-flex align-items-center justify-content-center">
                                <img src="{{$product->thumbnailUrl}}" id="thumbnail-preview" style="width: 50%;" />
                            </div>
                            <div class="col-md-12">
                                <input id="thumbnail" type="file"
                                       class="form-control @error('thumbnail') is-invalid @enderror" name="thumbnail">

                                @error('thumbnail')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="images"
                                   class="col-md-4 col-form-label text-md-end">{{ __('Additional Images') }}</label>

                            <div class="col-12 mb-4 d-flex align-items-center justify-content-center">
                                <div id="edit-images-wrapper" class="row">
                                    @foreach($product->images as $image)
                                        <div class='mb-4 col-md-6 images-wrapper-item'>
                                            <button class="btn btn-danger images-wrapper-item-remove"
                                                data-url="{{route('ajax.image.remove', $image)}}">
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                            <img src='{{$image->url}}' style='width: 100%' />
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input id="edit-images" type="file"
                                               class="form-control @error('images') is-invalid @enderror d-none" name="images[]" multiple>
                                    </div>
                                    <div class="col-md-6 d-flex align-items-center justify-content-end">
                                        <div id="spinner" class="spinner-border d-none me-2" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <button class="btn btn-outline-success add-images"
                                                data-upload="{{route('ajax.product.images.upload', $product)}}"
                                        >Upload images <i class="fa-solid fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-end">
                        <button type="submit" class="btn btn-outline-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('footer-js')
    @vite(['resources/js/admin/images-preview.js', 'resources/js/admin/images-actions.js'])
@endpush

