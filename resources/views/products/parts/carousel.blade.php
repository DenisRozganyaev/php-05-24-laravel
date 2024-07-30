<div id="productGallery" class="carousel slide">
    <div class="carousel-indicators">
        @foreach($gallery as $key => $item)
            <button type="button"
                    data-bs-target="#productGallery"
                    class="{{$key === 0 ? 'active' : ''}}"
                    data-bs-slide-to="{{$key}}"
            ></button>
        @endforeach
    </div>
    <div class="carousel-inner">
        @foreach($gallery as $key => $url)
            <div class="carousel-item {{$key === 0 ? 'active' : ''}}">
                <img src="{{ $url }}" class="d-block w-100" />
            </div>
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#productGallery" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#productGallery" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
