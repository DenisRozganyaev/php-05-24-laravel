<li class="nav-item dropdown">
    <a id="productList" class="nav-link" href="{{ route('admin.orders.index') }}">
        Orders
    </a>
</li>
<li class="nav-item dropdown">
    <a id="productList" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        Products
    </a>

    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="productList">
        <a class="dropdown-item" href="{{ route('admin.products.create') }}">
            Create Product
        </a>
        <a class="dropdown-item" href="{{ route('admin.products.index') }}">
            All Products
        </a>
    </div>
</li>

<li class="nav-item dropdown">
    <a id="categoriesList" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        Categories
    </a>

    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="categoriesList">
        <a class="dropdown-item" href="{{ route('admin.categories.create') }}">
            Create Category
        </a>
        <a class="dropdown-item" href="{{ route('admin.categories.index') }}">
            All Categories
        </a>
    </div>
</li>

