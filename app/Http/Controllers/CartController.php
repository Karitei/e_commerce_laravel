<?php

namespace App\Http\Controllers;



use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('carts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {




        $double = Cart::search(function ($cartItem, $rowId) use ($request) {
            return $cartItem->id === $request->id;
        });

        if ($double->isNotEmpty()) {
            return redirect()->route('products.index')->with('success', 'Le produit à déjà été ajouté au panier');
        } else {

            $product = Product::find($request->id);

            Cart::add($product->id, $product->title, '1', $product->price)->associate('App\Product');
            return redirect()->route('products.index')->with('success', 'Le produit à bien été ajouté au panier');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $rowId)
    {
        $data = $request->json()->all();

        $validator = validator::make($request->all(),[
            'qty' => 'required|numeric|between:1,6'
        ]);

        if($validator->false()){
            Session::flash('danger', 'La quantité est devenue ne doit pas dépasser 6');
            return response()->json(['error' => 'Cart quantitty has not been updated']);
        }
        Cart::update($rowId, $data['qty']);
        Session::flash('success', 'La quantité est devenue: '.$data['qty']);
        return response()->json(['success' => 'Cart quantitty has been updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($rowId)
    {
        Cart::remove($rowId);
        return back()->with('success','Le produit a été supprimé');
    }
}
