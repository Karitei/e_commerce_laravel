@extends('layouts.front')

@section('content')

    <div class="col-md-12">
        <div class="row no-gutters border rounded overflow-hidden position-relative ">
            <div class="col p-4 d-flex flex-column position-relative">

                <muted class="d-inline-block mb-2 text-info">
                    <span class="badge badge-info">{{ $stock }}</span>
                    @foreach ($product->categories as $category)
                        {{ $category->name }}{{ $loop->last ? '' : ', '}}
                    @endforeach
                </muted>

                <h5 class="mb-4">{{ $product->title }}</h5>
                <div class="mb-1 text-muted">Ajouté le: {{ $product->created_at->format('d/m/y') }}</div>
                <p class="card-text mb-auto">{{ $product->subtitle }}</p>
                <p class="card-text mb-auto">{!!  $product->description !!}</p>
                <strong> <p class="mb-4 display-4 text-secondary">{{ $product->getPrice() }}</p></strong>

                @if($stock === 'disponible')
                    <form action="{{route('cart.store')}}" method="post" class="mx-auto">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product->id }}">
                        <button type="submit"  class="btn btn-dark col-ms-5">Ajouter au panier</button>
                    </form>
                @endif
            </div>

            <div class="col-ml-3 mt-3 d-none d-lg-block">
                <img src='{{ asset('storage/'.$product->image) }}' alt="" id="mainImage">
                <div class="mr-2 mb-2 mt-2">
                    @if($product->images)
                        <img src='{{ asset('storage/'.$product->image) }}' alt="" width="50" class="img-thumbnail">
                        @foreach(json_decode($product->images, true) as $image)
                            <img src='{{ asset('storage/'.$image) }}' alt="" width="50" class="img-thumbnail">
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-JS')
    <script>
        var mainImage = document.querySelector('#mainImage');
        var thumbnails = document.querySelectorAll('.img-thumbnail');

        thumbnails.forEach((element)=> element.addEventListener('click', changeImage));
        
        function  changeImage(e) {
            mainImage.src =  this.src;
            
        }
    </script>

@endsection