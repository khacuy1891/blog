<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use File;


class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
		//Auth::logout();
    }

    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function search(Request $request)
    {
        $key_search = $request->input('key_search');
        $products = null;
        
        if($key_search) {
            $products = Product::where('name', 'LIKE', '%' . $key_search. '%')->get();
        } else {
            $products = Product::all();
        }

        return view('products.index', compact('products', 'key_search'));
    }

    public function create()
    {
		$categories = Category::all()->pluck('name', 'id')
											->prepend('Select a category', '');
        $product_parents = Product::all()->pluck('name', 'id')
                                            ->prepend('Select parent product', '');
        return view('products.create', compact('product_parents', 'categories') );
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->all();
        if($request->hasFile('image')){
            $image_name = time().'.'.$request->image->getClientOriginalExtension();
            $input['image'] = $image_name;
            $request->image->move(public_path(config('path.icon')), $image_name);
        }

		//var_dump($input); die;
        $product = Product::create($input);
		
        return redirect()->route('products.index');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $product_parents = Product::all()->where('id', '<>', $id)
                                            ->pluck('name', 'id')
                                            ->prepend('Select parent product', '');
		
		$categories = Category::all()->pluck('name', 'id')
											->prepend('Select a category', '');
											
        return view('products.edit', compact('product', 'product_parents', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            //'icon' => 'required',
        ]);

        $input = $request->all();
        
        if($request->hasFile('icon')){
            $iconName = time().'.'.$request->icon->getClientOriginalExtension();
            $input['icon'] = $iconName;
            $request->icon->move(public_path(config('path.icon')), $iconName);
        }

        $product = Product::find($id);
        $product->update($input); 
        return redirect()->route('products.index');
    }

    public function show($id)
    {
        $product = Product::find($id);
        $product_parents = Product::all()->where('id', '<>', $id)
                                            ->pluck('name', 'id')
                                            ->prepend('Select parent product', '');
		$categories = Category::all()->pluck('name', 'id')
											->prepend('Select a category', '');

        return view('products.show', compact('product', 'product_parents', 'categories'));
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $message = "Delete fail";
		
        if( $product ) {
            $product->delete();
            File::delete( public_path(config('path.icon')).'/'.$product->image);
            $message = "Delete success!";
        }
		
		return redirect()->route('products.index');
    }
}
