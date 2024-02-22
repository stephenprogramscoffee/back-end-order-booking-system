<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\OrderDetail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;


class OrderBookingController extends Controller
{
    public function getData(Request $request)
    {
        $customers = Customer::all();
        $products = Product::all();
        $orders = Order::with(['customer', 'details'])
            ->where(function($query) use ($request) {
                if ($request->order_number != '') {
                    $query->where('order_number', 'LIKE', '%'.$request->order_number.'%');
                }
            })
            ->whereHas('customer', function($query) use ($request) {
                if ($request->cus_name != '') {
                    $query->where('customer_name', 'LIKE', '%'.$request->cus_name.'%');
                }
            })
            ->get();

        return response()->json([
            'customers' => $customers,
            'products' => $products,
            'orders' => $orders
        ]);
    }

    public function createOrder(Request $request)
    {
        if ($request->all()) {
            $product = Product::where('product_code', $request->prod_code)->first();
            if (! $product) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Failed to update order! Product not found.'
                ]);
            }

            $customer = Customer::where('customer_code', $request->cus_code)->first();
            if (! $customer) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Failed to update order! Customer not found.'
                ]);
            }

            $order = new Order();
            $order_id = Str::random(10);

            $order->customer_code = $request->cus_code;
            $order->order_number = $order_id;
            $order->status = 1;
            $order->save();

            $orderDetail = new OrderDetail();
            $orderDetail->order_number = $order_id;
            $orderDetail->product_code = $request->prod_code;
            $orderDetail->gross_sales = $product->price * $request->quantity;
            $orderDetail->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Order created successfully!'
            ]);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Failed to update order! Please try again. (2)'
        ]);
    }

    public function cancelOrder(Request $request)
    {
        $order = Order::where('customer_code', $request->cus_code)
            ->where('order_number', $request->order_number)
            ->first();

        if (! $order) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Failed to cancel order! Please try again.'
            ]);
        }

        $orderDetail = OrderDetail::where('order_number', $request->order_number)->first();

        if (! $orderDetail) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Failed to cancel order! Please try again. (2)'
            ]);
        }

        $order->status = 0;
        $order->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Order cancelled successfully!'
        ]);
    }

    public function updateOrder(Request $request) {
        $order = Order::where('customer_code', $request->cus_code)
            ->where('order_number', $request->order_number)
            ->first();

        if (! $order) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Failed to update order! Please try again.'
            ]);
        }

        $product = Product::where('product_code', $request->prod_code)->first();

        if (! $product) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Failed to update order! Product not found.'
            ]);
        }

        $orderDetail = OrderDetail::where('order_number', $request->order_number)->first();

        $orderDetail->product_code = $request->prod_code;
        $orderDetail->gross_sales = $product->price * $request->quantity;
        $orderDetail->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Order updated successfully!'
        ]);
    }

    public function getOrders()
    {
        $orders = Order::with(['customer', 'details'])->get();

        return response()->json([
            'orders' => $orders
        ]);
    }
}
