<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Category;
use File;


class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
		//Auth::logout();
    }

    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function search(Request $request)
    {
        $key_search = $request->input('key_search');
        $categories = null;
        
        if($key_search) {
            $categories = Category::where('name', 'LIKE', '%' . $key_search. '%')->get();
        } else {
            $categories = Category::all();
        }

        return view('categories.index', compact('categories', 'key_search'));
    }

    public function create()
    {
        $category_parents = Category::all()->pluck('name', 'id')
                                            ->prepend('Select parent category', '');
        return view('categories.create', compact('category_parents') );
    }

    public function store(Request $request)
    {
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
        $category = Category::find($id);
        $category_parents = Category::all()->where('id', '<>', $id)
                                            ->pluck('name', 'id')
                                            ->prepend('Select parent category', '');

        return view('categories.edit', compact('category', 'category_parents'));
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

        $category = Category::find($id);
        $category->update($input); 
        return redirect()->route('categories.index');
    }

    public function show($id)
    {
        $category = Category::find($id);
        $category_parents = Category::all()->where('id', '<>', $id)
                                            ->pluck('name', 'id')
                                            ->prepend('Select parent category', '');

        return view('categories.show', compact('category', 'category_parents'));
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $message = "Delete fail";
		
        if( $category ) {
            $category->delete();
            File::delete( public_path(config('path.icon')).'/'.$category->icon);
            $message = "Delete success!";
        }
		
		return redirect()->route('categories.index');
    }
}
