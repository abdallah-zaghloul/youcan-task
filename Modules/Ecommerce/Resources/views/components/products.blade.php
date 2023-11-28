<!-- Products Component View -->
<section>
    <div class="container py-5">
        <div class="row">

            <div class="search-box mb-4">
                <form method="GET" action="{{route('ecommerce.index')}}">
                    @csrf
                    <div class="input-group m-auto">
                        <!-- Reset -->
                        <a class="btn btn-danger pt-4" href="{{route('ecommerce.index')}}">Reset</a>


                        <label class="input-group-prepend  ms-1">
                            <!-- Sort By -->
                            <select name="sortBy" class="dropdown form-select mb-1">
                                <option class="dropdown-item"
                                        value="created_at" {{$sortBy === "created_at" ? "selected" : ""}}>Created At
                                </option>
                                <option class="dropdown-item" value="price" {{$sortBy === "price" ? "selected" : ""}}>
                                    Price
                                </option>
                            </select>

                            <!-- Dir -->
                            <select name="dir" class="input-group-prepend dropdown form-select">
                                <option class="dropdown-item" value="asc" {{$dir === "asc" ? "selected" : ""}}>Asc
                                </option>
                                <option class="dropdown-item" value="desc" {{$dir === "desc" ? "selected" : ""}}>Desc
                                </option>
                            </select>
                        </label>

                        <!-- Search Bar -->
                        <input class="form-control ms-1" type="text" value="{{$categoryName}}" name="categoryName"
                               placeholder="Search By Category" autofocus autocomplete>
                        <button class="btn btn-dark" type="submit">Search</button>
                    </div>
                </form>
                @error('categoryName') <span class="error">{{ $message }}</span> <br> @enderror
                @error('sortBy') <span class="error">{{ $message }}</span> <br> @enderror
                @error('dir') <span class="error">{{ $message }}</span> <br> @enderror
            </div>


            <!-- Products -->

            @foreach($products as $product)
                <!-- Product -->
                <div class="col-md-6 col-lg-4 mb-4 mb-md-0">
                    <div class="card">
                        <div class="d-block justify-content-between p-3">
                            <!-- Name -->
                            <h5 class="lead mb-0">Name: {{$product->name}}</h5>

                            <!-- Categories -->
                            @if($product->categories->isNotEmpty())
                                <h5 class="lead mb-0">Categories:
                                    {!!
                                        $product->categories->pluck('name')
                                        ->transform(fn($categoryName) => "<small ".'class="btn-sm btn btn-primary mb-1">'."$categoryName</small>")
                                        ->implode("&nbsp;")
                                    !!}
                                </h5>
                            @endif

                            <!-- Description -->
                            <small>{{@substr($product->description, 0, 50)}}</small>
                        </div>

                        <!-- Image -->
                        <img
                            src="{{$product->image}}"
                            class="card-img-top"/>

                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">

                                <!-- Price -->
                                <h5 class="text-dark mb-0">Price: {{$product->price}}</h5>
                            </div>
                        </div>

                    </div>
                    <br>
                </div>
            @endforeach

            <hr class="my-4">
            <div class="pagination justify-content-center">
                {{$products->links()}}
            </div>

        </div>
    </div>
</section>
