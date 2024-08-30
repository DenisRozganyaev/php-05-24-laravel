@if ($isFollowed)
    <form action="{{ route('wishlist.remove', $product) }}" method="POST">
        @csrf
        @method('DELETE')
        <input type="hidden" value="price" name="type"/>
        @unless($mini)
            <label for="btn-add-price">Unsubscribe on price change</label>
        @endunless
        <button id="btn-add-price" type="submit" class="btn btn-outline-danger">
            <i class="fa-solid fa-chart-line"></i>
        </button>
    </form>
@else
    <form action="{{ route('wishlist.add', $product) }}" method="POST">
        @csrf
        <input type="hidden" value="price" name="type"/>
        @unless($mini)
            <label for="btn-add-price">Subscribe on price change</label>
        @endunless
        <button id="btn-add-price" type="submit" class="btn btn-outline-primary">
            <i class="fa-solid fa-chart-line"></i>
        </button>
    </form>
@endif
