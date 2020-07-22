<?php

namespace App\Http\Controllers;


use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class productsController extends Controller
{
   public function index(){

       if(request()->categorie){
           $products = Product::with('categories')->whereHas('categories', function ($query){
               $query->where('slug', request()->categorie);
           })->orderBy('created_at','DESC')->paginate(6);
       }else{

       $products = Product::with('categories')->orderBy('created_at','DESC')->paginate(6) ;

       }
       return view('products.index')->with('products', $products);
   }

   public function show($slug){

       $product = Product::Where('slug', $slug)->firstOrFail();
       $stock = $product->stock === 0 ? 'indisponible' : 'disponible';
       return view('products.show', [
           'product' => $product,
           'stock' => $stock
       ]);
   }

   public function search(){
       $q = request()->input('q');

       $products = Product::Where('title','like',"%$q%")
           ->orWhere('description','like',"%$q%")
           ->paginate(6);

       return view('products.search')->with('products', $products);
   }
}
