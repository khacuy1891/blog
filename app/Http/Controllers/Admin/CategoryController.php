<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use File;
use Session;

use App\Models\Category;


class CategoryController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
		$user = Auth::user();
		//die($user);
		//View::share('user', $user);		
    }
	
	public function checkAdmin()
	{
		$admin = Session::get('admin');
		if (!$admin) {
			$message = 'You must login to access';
			return view('admin.login', compact('message'));
		}
	}

    public function index(Request $request)
    {
		$key_search = $request->input('key_search');
		$admin = Session::get('admin');
		if (!$admin) {
			$message = 'You must login to access';
			return view('admin.login', compact('message'));
		}
		
		Auth::logout();
        if($key_search) {
            $categories = Category::where('name', 'LIKE', '%' . $key_search. '%')->paginate(3);
        } else {
            $categories = Category::paginate(3);
        }
		
		return view('admin.categories.index', compact('categories', 'key_search'));
    }

    public function create()
    {
		$admin = Session::get('admin');
		if (!$admin) {
			$message = 'You must login to access';
			return view('admin.login', compact('message'));
		}
		
        $category_parents = Category::all()->pluck('name', 'id')
                                            ->prepend('Select parent category', '');
        return view('admin.categories.create', compact('category_parents') );
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
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->all();
        if($request->hasFile('icon')){
            $iconName = time().'.'.$request->icon->getClientOriginalExtension();
            $input['icon'] = $iconName;
            $request->icon->move(public_path(config('path.icon')), $iconName);
        }

        $category = Category::create($input);
        return redirect()->route('categories.index');
    }

    public function edit($id)
    {
		$admin = Session::get('admin');
		if (!$admin) {
			$message = 'You must login to access';
			return view('admin.login', compact('message'));
		}
		
        $category = Category::find($id);
        $category_parents = Category::all()->where('id', '<>', $id)
                                            ->pluck('name', 'id')
                                            ->prepend('Select parent category', '');
		
        return view('admin.categories.edit', compact('category', 'category_parents'));
    }

    public function update(Request $request, $id)
    {
		$admin = Session::get('admin');
		if (!$admin) {
			$message = 'You must login to access';
			return view('admin.login', compact('message'));
		}
		
		$category = Category::find($id);
		
        $this->validate($request, [
            'name' => 'required|max:255',
            //'icon' => 'required',
        ]);

        $input = $request->all();
        if($request->hasFile('icon')){
			File::delete( public_path(config('path.icon')).'/'.$category->icon);
			
            $iconName = time().'.'.$request->icon->getClientOriginalExtension();
            $input['icon'] = $iconName;
            $request->icon->move(public_path(config('path.icon')), $iconName);
        }

        $category->update($input); 
        return redirect()->route('admin.categories.show', [$category->id]);
    }

    public function show($id)
    {
		$admin = Session::get('admin');
		if (!$admin) {
			$message = 'You must login to access';
			return view('admin.login', compact('message'));
		}
		
        $category = Category::find($id);
        $category_parents = Category::all()->where('id', '<>', $id)
                                            ->pluck('name', 'id')
                                            ->prepend('Select parent category', '');

        return view('admin.categories.show', compact('category', 'category_parents'));
    }

    public function destroy($id)
    {
		$admin = Session::get('admin');
		if (!$admin) {
			$message = 'You must login to access';
			return view('admin.login', compact('message'));
		}
		
        $category = Category::find($id);
        $message = "Delete fail";
		
        if( $category ) {
            $category->delete();
            File::delete( public_path(config('path.icon')).'/'.$category->icon);
            $message = "Delete success!";
        }
		
		return redirect()->route('admin.categories.index');
    }
}
