@extends('ecommerce::layouts.master')
@section('content')

    <div class="container ms-auto">
        <div class="card-body">

            <!-- Success -->
            @if(session('success'))
                <div class="col-md-4 offset-md-4 alert alert-success text-center" role="alert">
                    {{ session('success') }}
                    @php(session()->remove('success'))
                </div>
            @endif

            <!-- Back Form -->
            <form method="GET" action="{{route('ecommerce.index')}}">

                <div class="row mb-3">
                    <div class="col-md-4 offset-md-4">
                        <button type="submit" class="btn btn-danger">
                            Back
                        </button>
                    </div>
                </div>

            </form>

            <!-- Product Form -->
            <form method="POST" action="{{route('ecommerce.products.store')}}" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

                    <!-- Name -->
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                               name="name"
                               value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                        <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                        @enderror
                    </div>
                </div>

                <!-- Price -->
                <div class="row mb-3">
                    <label for="price" class="col-md-4 col-form-label text-md-end">Price</label>

                    <div class="col-md-6">
                        <input id="price" type="number" step="1" min="1" max="10000000"
                               class="form-control @error('price') is-invalid @enderror" name="price"
                               value="{{ old('price') }}" required>

                        @error('price')
                        <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                        @enderror
                    </div>

                </div>

                <!-- Image -->
                <div class="row mb-3">
                    <label for="image" class="col-md-4 col-form-label text-md-end">Image</label>

                    <div class="col-md-6">
                        <input type="file" id="image" class="form-control @error('image') is-invalid @enderror"
                               name="image"
                               value="{{ old('image') }}">

                        @error('image')
                        <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                        @enderror
                    </div>

                </div>

                <!-- Description -->
                <div class="row mb-3">
                    <label for="description" class="col-md-4 col-form-label text-md-end">Description</label>

                    <div class="col-md-6">
                <textarea id="price" type="text" class="form-control @error('description') is-invalid @enderror"
                          name="description"
                          autocomplete="description">
                    {{ old('description') }}
                </textarea>

                        @error('description')
                        <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                        @enderror
                    </div>

                </div>

                <!-- Categories -->
                <div class="row mb-3">
                    <label for="category_ids" class="col-md-4 col-form-label text-md-end">Categories</label>

                    <div class="col-md-6">
                        <select id="category_ids" class="form-control @error('category_ids') is-invalid @enderror"
                                name="category_ids[]"
                                multiple>

                            @foreach($categories as $category)
                                <option class="dropdown-item" value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach

                        </select>

                        @error('category_ids')
                        <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                        @enderror
                    </div>

                </div>


                <div class="row mb-0 ">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Submit
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
