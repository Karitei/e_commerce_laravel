<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Laravel 7">

    @yield('extra-meta')

    <title>E-commerce Project</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    @yield('extra-script')

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- FontAwesome 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
    <!-- Custom styles for this template -->

    <link rel="stylesheet" href="{{asset('css\front.css')}}">

</head>
<body>
<div class="container">
    <header class="blog-header py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-4 pt-1">
                <a class="text-muted" href="{{ route('carts.index') }}">Panier <span class="badge badge-pill badge-dark"> {{ Cart::count() }}</span></a>
            </div>
            <div class="col-4 text-center">
                <a class="blog-header-logo text-dark" href="{{route('products.index')}}">Large</a>
            </div>
            <div class="col-4 d-flex justify-content-end align-items-center">

                @include('partials.search')
                @include('partials.auth')

            </div>
        </div>
    </header>

    <div class="nav-scroller py-1 mb-2">
        <nav class="nav d-flex justify-content-between">
            @foreach(App\Category::all() as $category)
                <a class="p-2 text-muted" href="{{route('products.index',['categorie' => $category->slug])}}">{{$category->name}}</a>
            @endforeach
        </nav>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('danger'))
        <div class="alert alert-danger">
            {{ session('danger') }}
        </div>
    @endif

    @if(request()->input('q'))
        <h6>  "  {{ $products->total() }} " résultats pour : "{{request()->q }}"</h6>
    @endif

    <div class="row mb-2">

    @yield('content')

    </div>
</div>



<footer class="blog-footer">
    <p>Blog template built for <a href="https://getbootstrap.com/">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
    <p>
        <a href="#">Back to top</a>
    </p>
</footer>

@yield('extra-JS')
</body>

</html>
