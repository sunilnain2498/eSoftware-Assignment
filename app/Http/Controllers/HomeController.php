<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Products;
use App\Cart;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Products::all();
        $user = Auth::user();
        return view('home')->with(['products'=>$products, 'user'=>$user]);
    }

    public function create_product()
    {
        $user = Auth::user();
        return view('product.create');
    }
    public function add_new_product(Request $request)
    {
        $validatedData = $request->validate([
          'title' => 'required',
          'descr' => 'required',
          'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
          'price' => 'required',
        ]);

        $imageName = time().'.'.$request->image->extension();  
     
        $image_path = $request->image->move(public_path('images'), $imageName);

        $product = new Products;
 
        $product->title = $request->title;
        $product->description = $request->descr;
        $product->price = $request->price;
        $product->image = $imageName;
 
        $product->save();
 
        return redirect()->route('home');
 
    }

    public function edit_product($id)
    {
        // echo 'edit_product';
        $product = Products::find($id);
        $user = Auth::user();
        return view('product.edit')->with(['product'=>$product, 'user'=>$user]);
    }
    public function save_edit_product(Request $request, $id)
    {
        $validatedData = $request->validate([
          'title' => 'required',
          'descr' => 'required',
          'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
          'price' => 'required',
        ]);
        if($request->image){
            $imageName = time().'.'.$request->image->extension();  
            $image_path = $request->image->move(public_path('images'), $imageName);
            Products::where('id', $id)
                ->update([
                            'title'     => $request->title,
                            'description'=> $request->descr,
                            'price'     => $request->price,
                            'image'     => $imageName,
                        ]);
        }else{
            Products::where('id', $id)
                ->update([
                            'title'     => $request->title,
                            'description'=> $request->descr,
                            'price'     => $request->price,
                        ]);

        }



        return redirect()->route('home');
    }
    public function add_cart($id)
    {
        $user = Auth::user();
        $product = new Cart;
 
        $product->product_id = $id;
        $product->user_id = $user->id;
 
        $product->save();
        return redirect()->route('home');
    }
    public function delete_product($id)
    {
        Products::where('id', $id)->delete();
        return redirect()->route('home');
        // echo 'delete_product';
        // $products = Products::all();
        // $user = Auth::user();
        // return view('home')->with(['products'=>$products, 'user'=>$user]);
    }
}
