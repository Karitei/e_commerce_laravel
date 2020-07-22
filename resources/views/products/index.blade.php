@extends('layouts.front')

@section('content')
    @foreach($products as $product)
        <div class="col-md-6">
            <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                <div class="col p-4 d-flex flex-column position-static">

                    <small class="d-inline-block mb-2">
                        @foreach ($product->categories as $category)
                            {{ $category->name }}{{ $loop->last ? '' : ', '}}
                        @endforeach
                    </small>

                    <h5 class="mb-0">{{ $product->title }}</h5>
                    <div class="mb-1 text-muted">{{ $product->created_at->format('d/m/y') }}</div>

                    <strong> <p class="card-text mb-auto">{{ $product->getPrice() }}</p></strong>

                    <a href="{{ route('product.show', $product->slug) }}" class="mt-auto stretched-link btn btn-info">Lire</a>
                </div>
                <div class="col-auto d-none d-lg-block">
                    <img src='{{ asset('storage/'.$product->image) }}' alt="">
                </div>
            </div>
        </div>

    @endforeach

        {{ $products->appends(request()->input())->Links()  }}
    

@endsection