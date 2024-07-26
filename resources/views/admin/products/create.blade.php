@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-center pt-5">
                <form class="card w-50" method="POST" enctype="multipart/form-data" action="{{route('admin.products.store')}}">
                    @csrf

                    <h5 class="card-header">Create product</h5>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('Title') }}</label>

                            <div class="col-md-6">
                                <input id="title" type="text"
                                       class="form-control @error('title') is-invalid @enderror" name="title"
                                       value="{{ old('title') }}" required autofocus>

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
                                       value="{{ old('SKU') }}" required>

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
                                    >{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="categories"
                                   class="col-md-4 col-form-label text-md-end">{{ __('Categories') }}</label>

                            <div class="col-md-6">
                                <select name="categories[]" id="categories"
                                        class="form-control @error('categories') is-invalid @enderror" multiple>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
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
                                       value="{{ old('price') }}"
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
                                       value="{{ old('discount') }}"
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
                                       value="{{ old('quantity') }}">

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
                                <img src="#" id="thumbnail-preview" style="width: 50%; display:none;" />
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
                                <div id="images-wrapper" class="row"></div>
                            </div>
                            <div class="col-md-12">
                                <input id="images" type="file"
                                       class="form-control @error('images') is-invalid @enderror" name="images[]" multiple>

                                @error('images')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
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

@push('footer-js')
    @vite(['resources/js/admin/images-preview.js'])
@endpush
