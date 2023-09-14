<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Product\Cart;
use App\Models\Product\Order;
use App\Models\Product\Booking;


use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{

    public function singleProduct($id)
    {
        $product = Product::find($id);

        $relatedProducts = Product::where('type', $product->type)
            ->where('id', '!=', $id)->take(4)
            ->orderBy('id', 'desc')->get();


        $checkingInCart = Cart::where('pro_id', $id)
            ->where('user_id', Auth::user()->id)
            ->count();

        return view('products.productsingle', compact('product', 'relatedProducts', 'checkingInCart'));
    }


    public function addCart(Request $request, $id)
    {
        $addCart = Cart::create([
            "pro_id" => $request->pro_id,
            "name" => $request->name,
            "image" => $request->image,
            "price" => $request->price,
            "user_id" => Auth::user()->id
        ]);

        return Redirect::route('product.single', $id)->with(["success" => "Product added to cart successfully"]);
    }


    public function cart()
    {
        $cartProducts = Cart::where("user_id", Auth::user()->id)
            ->orderBy('id', 'desc')
            ->get();

        $totalProduct = Cart::where('user_id', Auth::user()->id)
            ->sum('price');

        return view('products.cart', compact('cartProducts', 'totalProduct'));
    }

    public function deleteProductCart($id)
    {
        $deleteProductCart = Cart::where("user_id", Auth::user()->id)
            ->where('pro_id', $id);

        $deleteProductCart->delete();

        return Redirect::route('cart')->with(["delete" => "Product deleted from cart successfully"]);
    }


    public function prepareCheckout(Request $request)
    {
        $value = $request->price;

        $price = Session::put('price', $value);

        $newPrice = Session::get($price);

        if ($newPrice > 0)
            return Redirect::route('checkout');
    }

    public function checkout()
    {
        return view('products.checkout');
    }

    public function storeCheckout(Request $request)
    {
        $checkout = Order::create($request->all());


        return Redirect::route('product.pay');
    }

    public function payWithPaypal()
    {
        return view('products.pay');
    }

    public function success()
    {
        $deleteItems = Cart::where('user_id', Auth::user()->id);
        $deleteItems->delete();

        if ($deleteItems) {
            Session::forget('price');
            return view('products.success');
        }
    }


    public function bookTables(Request $request)
    {

        Request()->validate([
            "first_name" => "required|max:40",
            "last_name" => "required|max:40",
            "date" => "required",
            "time" => "required",
            "phone" => "required|max:40"
        ]);

        if ($request->date > date('n/j/Y')) {
            $bookTables = Booking::create($request->all());
        } else {
            return Redirect::route('home')->with(['date' => 'Choose a date in future']);
        }
    }



    public function menu()
    {
        $desserts = Product::select()->where('type', 'desserts')
            ->orderBy('id', 'desc')
            ->take(4)->get();

        $drinks = Product::select()->where('type', 'drinks')
            ->orderBy('id', 'desc')
            ->take(4)->get();

        return view('products.menu', compact('desserts', 'drinks'));
    }
}
