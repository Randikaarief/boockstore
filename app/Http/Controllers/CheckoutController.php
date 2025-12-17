<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (count($cart) == 0) {
            return redirect()->route('books.index')->with('error', 'Your cart is empty.');
        }

        // Calculate total price
        $total = 0;
        foreach ($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        try {
            DB::beginTransaction();

            // Create the order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $total,
                'status' => 'pending',
            ]);

            // Create order items and update book stock
            foreach ($cart as $book_id => $details) {
                $book = Book::find($book_id);
                if (!$book || $book->stock < $details['quantity']) {
                    throw new \Exception('Not enough stock for ' . $book->title);
                }

                $order->orderItems()->create([
                    'book_id' => $book_id,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                ]);

                $book->decrement('stock', $details['quantity']);
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'An error occurred during checkout: ' . $e->getMessage());
        }

        // Clear the cart
        session()->forget('cart');

        return redirect()->route('checkout.success')->with('success', 'Your order has been placed successfully!');
    }

    public function success()
    {
        return view('checkout.success');
    }
}