<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Admin;
use App\Models\Product\Product;
use App\Models\Product\Order;
use App\Models\Product\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;



class AdminsController extends Controller
{
    public function viewLogin()
    {
        return view('admins.login');
    }

    public function checkLogin(Request $request)
    {
        $remember_me = $request->has('remember_me') ? true : false;

        if (auth()->guard('admin')->attempt(['email' => $request->input("email"), 'password' => $request->input("password")], $remember_me)) {

            return redirect()->route('admins.dashboard');
        }
        return redirect()->back()->with(['error' => 'error logging in']);
    }

    public function index()
    {

        $products = Product::select()->count();
        $orders = Order::select()->count();
        $bookings = Booking::select()->count();
        $admins = Admin::select()->count();

        return view('admins.index', compact('products', 'orders', 'bookings', 'admins'));
    }

    public function viewAdmins()
    {
        $admins = Admin::select()->orderBy('id', 'desc')->get();

        return view('admins.alladmins', compact('admins'));
    }

    public function createAdmins()
    {

        return view('admins.createadmins');
    }

    public function storeAdmins(Request $request)
    {
        $createadmins = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),

        ]);

        if ($createadmins) {
            return redirect()->route('all.admins')->with(['success' => 'Admin created successfully']);
        }
    }

    public function allProducts()
    {

        $products = product::select()->orderBy('id', 'desc')->get();

        return view('admins.products', compact('products'));
    }

    public function storeProduct(Request $request)
    {

        $destinationPath = 'assets/images/';
        $myimage = $request->image->getClientOriginalName();
        $request->image->move(public_path($destinationPath), $myimage);

        $products = Product::create([
            "name" => $request->name,
            "image" => $request->image,
            "price" => $request->price,
            "description" => $request->description,
            "type" => $request->type
        ]);

        if ($products) {
            return redirect()->route('show.products');
        }
    }

    public function createProduct()
    {

        return view('admins.createproduct');
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);

        if (Storage::exists(public_path('assets/images/' . $product->image))) {
            Storage::delete(public_path('assets/images/' . $product->image));
        } else {
            //dd('File does not exists.');
        }

        $product->delete();


        return redirect()->route('show.products');
    }


    // order

    public function allOrders()
    {

        $orders = Order::select()->orderBy('id', 'desc')->get();

        return view('admins.orders', compact('orders'));
    }

    public function changeOrders($id)
    {

        $order = Order::find($id);

        return view('admins.changeorder', compact('order'));
    }

    public function updateOrders(Request $request, $id)
    {

        $order = Order::find($id);

        $order->update($request->all());

        if ($order) {
            return redirect()->route('show.orders');
        }
    }

    public function deleteOrders($id)
    {

        $orders = Order::find($id);

        $orders->delete();

        return redirect()->route('all.orders');
    }



    public function allBookings()
    {

        $bookings = Booking::select()->orderBy('id', 'desc')->get();

        return view('admins.bookings', compact('bookings'));
    }
}
