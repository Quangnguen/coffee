<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product\Booking;
use App\Models\Product\Order;
use App\Models\Product\Review;

use Illuminate\Support\Facades\Auth;
use Laravel\Ui\Presets\React;

class UsersController extends Controller
{


    public function writeReview()
    {

        return view('users.review');
    }


    public function displayBookings()
    {
        if (auth()->user()) {

            $bookings = Booking::select()
                ->where('user_id', Auth::user()->id)
                ->orderBy('id', 'desc')->get();
            return view('users.bookings', compact('bookings'));
        }
    }


    public function processWriteReview(Request $request)
    {
        if (auth()->user()) {
            $review = Review::create([
                "name" => Auth::user()->name,
                "review" => $request->review,
                "user_id" => Auth::user()->id
            ]);

            if ($review) {
                return view('users.review', compact('review'))->with(['review' => "Review submitted successfully"]);
            }
        }
    }

    public function displayOrders()
    {

        if (auth()->user()) {
            $orders = Order::select()
                ->where('user_id', Auth::user()->id)
                ->orderBy('id', 'desc')->get();
            return view('users.orders', compact('orders'));
        }
    }
}
