@extends('ecommerce::layouts.master')
@section('content')
    <div class="container">

        <!-- Create Product -->
        @auth('adminWeb')
            <form method="GET" action="{{route('ecommerce.products.create')}}">
                <button class="btn btn-dark ms-3"> Create Product</button>
            </form>
        @endauth

        <div class="row justify-content-center">

            <div class="card-body">
                <!-- Success -->
                @if(session('success'))
                    <div class="col-md-4 offset-md-4 alert alert-success text-center" role="alert">
                        {{ session('success') }}
                        @php(session()->remove('success'))
                    </div>
                @endif
            </div>

            <!-- Products Component -->
            @livewire('ecommerce::products')

        </div>

    </div>
@endsection
