@if ($isFollowed)
    <form action="{{ route('wishlist.remove', $product) }}" method="POST">
        @csrf
        @method('DELETE')
        <input type="hidden" value="exist" name="type"/>
        @unless($mini)
            <label for="btn-add-exist">Unsubscribe on exists</label>
        @endunless
        <button id="btn-add-exist" type="submit" class="btn btn-outline-danger">
            <i class="fa-regular fa-heart"></i>
        </button>
    </form>
@else
    <form action="{{ route('wishlist.add', $product) }}" method="POST">
        @csrf
        <input type="hidden" value="exist" name="type"/>
        @unless($mini)
            <label for="btn-add-exist">Subscribe on exists</label>
        @endunless
        <button id="btn-add-exist" type="submit" class="btn btn-outline-primary">
            <i class="fa-regular fa-heart"></i>
        </button>
    </form>
@endif
