<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use File;
use Session;

use App\Models\Product;
use App\Models\Category;



class ProductController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
		//Auth::logout();
    }

    public function index(Request $request)
    {
		$key_search = $request->input('key_search');
		$admin = Session::get('admin');
		if (!$admin) {
			$message = 'You must login to access';
			return view('admin.login', compact('message'));
		}
		
        if($key_search) {
            $products = Product::where('name', 'LIKE', '%' . $key_search. '%')->paginate(3);
        } else {
            $products = Product::paginate(3);
        }
		
        return view('admin.products.index', compact('products', 'key_search'));
    }

    public function search(Request $request)
    {
		$admin = Session::get('admin');
		if (!$admin) {
			$message = 'You must login to access';
			return view('admin.login', compact('message'));
		}
		
        $key_search = $request->input('key_search');
        $products = null;
        
        if($key_search) {
            $products = Product::where('name', 'LIKE', '%' . $key_search. '%')->paginate(3);
        } else {
            $products = Product::paginate(3);
        }

        return view('admin.products.index', compact('products', 'key_search'));
    }

    public function create()
    {
		$admin = Session::get('admin');
		if (!$admin) {
			$message = 'You must login to access';
			return view('admin.login', compact('message'));
		}
		
		$categories = Category::all()->pluck('name', 'id')
											->prepend('Select a category', '');
        $product_parents = Product::all()->pluck('name', 'id')
                                            ->prepend('Select parent product', '');
        return view('admin.products.create', compact('product_parents', 'categories') );
    }

    public function store(Request $request)
    {
		$admin = Session::get('admin');
		if (!$admin) {
			$message = 'You must login to access';
			return view('admin.login', compact('message'));
		}
		
        $this->validate($request, [
            'name' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->all();
        if($request->hasFile('image')){
            $image_name = time().'.'.$request->image->getClientOriginalExtension();
            $input['image'] = $image_name;
            $request->image->move(public_path(config('path.image')), $image_name);
        }

		//var_dump($input); die;
        $product = Product::create($input);
		
        return redirect()->route('admin.products.index');
    }

    public function edit($id)
    {
		$admin = Session::get('admin');
		if (!$admin) {
			$message = 'You must login to access';
			return view('admin.login', compact('message'));
		}
		
        $product = Product::find($id);
        $product_parents = Product::all()->where('id', '<>', $id)
                                            ->pluck('name', 'id')
                                            ->prepend('Select parent product', '');
		
		$categories = Category::all()->pluck('name', 'id')
											->prepend('Select a category', '');
											
        return view('admin.products.edit', compact('product', 'product_parents', 'categories'));
    }

    public function update(Request $request, $id)
    {
		$admin = Session::get('admin');
		if (!$admin) {
			$message = 'You must login to access';
			return view('admin.login', compact('message'));
		}
		
		$product = Product::find($id);
		
        $this->validate($request, [
            'name' => 'required|max:255',
            //'icon' => 'required',
        ]);

        $input = $request->all();
        
        if($request->hasFile('icon')){
			File::delete( public_path(config('path.image')).'/'.$product->image);
			
            $iconName = time().'.'.$request->icon->getClientOriginalExtension();
            $input['icon'] = $iconName;
            $request->icon->move(public_path(config('path.image')), $iconName);
        }

        $product->update($input); 
        return redirect()->route('admin.products.index');
    }

    public function show($id)
    {
		$admin = Session::get('admin');
		if (!$admin) {
			$message = 'You must login to access';
			return view('admin.login', compact('message'));
		}
		
        $product = Product::find($id);
        $product_parents = Product::all()->where('id', '<>', $id)
                                            ->pluck('name', 'id')
                                            ->prepend('Select parent product', '');
		$categories = Category::all()->pluck('name', 'id')
											->prepend('Select a category', '');

        return view('admin.products.show', compact('product', 'product_parents', 'categories'));
    }

    public function destroy($id)
    {
		$admin = Session::get('admin');
		if (!$admin) {
			$message = 'You must login to access';
			return view('admin.login', compact('message'));
		}
		
        $product = Product::find($id);
        $message = "Delete fail";
		
        if( $product ) {
            $product->delete();
            File::delete( public_path(config('path.icon')).'/'.$product->image);
            $message = "Delete success!";
        }
		
		return redirect()->route('admin.products.index');
    }
}
