<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::select()->orderBy('id', 'desc')->take('4')->get();

        return view('home', compact('products'));
    }

    public function login()
    {

        return view('auth.login');
    }

    public function about()
    {

        return view('pages.about');
    }

    public function services()
    {

        return view('pages.services');
    }

    public function contact()
    {

        return view('pages.contact');
    }
}
