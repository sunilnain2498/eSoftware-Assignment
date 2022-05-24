<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Products;
use App\Orders;
use App\Cart;
use App\OrderProducts;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $user = Auth::user();
        $orders = Orders::where('user_id',$user->id)->get();
        // dd($orders);
        return view('order.home')->with(['orders'=>$orders, 'user'=>$user]);
    }
    public function cart_page()
    {
        $user = Auth::user();
        $products = array();
        $productIds = Cart::select("product_id")->where('user_id',$user->id)->get();
        $products = Products::select("*")
                    ->whereIn('id', $productIds)
                    ->get();
        // dd($products);
        return view('order.cart')->with(['products'=>$products, 'user'=>$user]);
    }
    public function remove_product($id)
    {
        $user = Auth::user();
        Cart::where('user_id', $user->id)->where('product_id',$id)->delete();
        return redirect()->route('cartPage');
    }
    public function checkout_form()
    {
        $user = Auth::user();
        $products = array();
        $productIds = Cart::select("product_id")->where('user_id',$user->id)->get();
        $products = Products::select("*")
                    ->whereIn('id', $productIds)
                    ->get();
        return view('order.orderForm')->with(['products'=>$products, 'user'=>$user]);
    }
    public function checkout_order(Request $request)
    {
        $validatedData = $request->validate([
          'address' => 'required',
        ]);
        $user = Auth::user();

        $order = new Orders;
        $order->user_id = $user->id;
        $order->total = $request->total;
        $order->address = $request->address;
        $order->save();
        $order_id = $order->id;

        $cartProductIds = Cart::select("product_id")->where('user_id',$user->id)->get();
        $cartProducts = Products::select("*")
                    ->whereIn('id', $cartProductIds)
                    ->get();
        foreach ($cartProducts as $cartProduct) {
            $relOrderProduct = new OrderProducts;
            $relOrderProduct->user_id = $user->id;
            $relOrderProduct->product_id = $cartProduct->id;
            $relOrderProduct->order_id = $order_id;
            $relOrderProduct->save();
        }

        return redirect()->route('orders');
    }
    public function view_order($id)
    {
        $user = Auth::user();
        $order = Orders::find($id);
        $productIds = OrderProducts::select("product_id")->where('order_id',$id)->get();
        $orderProducts = Products::select("*")
                    ->whereIn('id', $productIds)
                    ->get();
        return view('order.orderView')->with(['products'=>$orderProducts, 'order'=>$order, 'user'=>$user]);
    }
    public function delete_order($id)
    {
        $user = Auth::user();
        Orders::find($id)->delete();
        OrderProducts::where('order_id',$id)->delete();
        return redirect()->route('orders');
    }
    public function edit_order($id)
    {
        $user = Auth::user();
        $order = Orders::find($id);
        $productIds = OrderProducts::select("product_id")->where('order_id',$id)->get();
        $orderProducts = Products::select("*")
                    ->whereIn('id', $productIds)
                    ->get();
        return view('order.orderEditForm')->with(['products'=>$orderProducts, 'user'=>$user, 'order'=>$order]);
    }
    public function remove_product_order($oid, $pid)
    {
        $user = Auth::user();
        OrderProducts::where('order_id',$oid)->where('product_id',$pid)->where('user_id',$user->id)->delete();
        $total = Orders::find($oid)->total;
        // dd($total);
        $pPrice = Products::find($pid)->price;
        Orders::find($oid)->update([
                            'total'     => ($total-$pPrice),
                        ]);

        return redirect()->route('editOrder',['id'=>$oid]);
        // $order = Orders::find($oid);
        // $productIds = OrderProducts::select("product_id")->where('order_id',$oid)->get();
        // $orderProducts = Products::select("*")
        //             ->whereIn('id', $productIds)
        //             ->get();
        // return view('order.orderEditForm')->with(['products'=>$orderProducts, 'user'=>$user, 'order'=>$order]);
    }
}
