<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Practical;
class Category extends Controller
{
  public function index()
  {
    $category = Practical::all();
    return view('category.list', compact('category'));
  }
  
   public function create()
  {
    return view('category.create');
  }
  
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required'
    ]);
	$category = $request->name;
	foreach ($category as $key => $category_name) {
		$category = new Practical();
		$category->name = $category_name;
		$category->save();
	}
    return redirect()->route('category.index')->with('success', 'category created successfully.');
  }
  
  public function edit(Practical $category)
  {
    return view('category.edit', compact('category'));
  }
  
  public function update(Request $request,Practical $category)
  {
    $request->validate([
      'name' => 'required'
    ]);
	
    $category = Practical::find($category->id);
    $category->name = $request->name;
	$category->save();
	
    return redirect()->route('category.index')->with('success', 'Post updated successfully.');
  }
  public function delete($id)
  {
    $category = Practical::find($id);
    $category->delete();
	
    return redirect()->route('category.index')->with('success', 'Post deleted successfully');
  }
  
 public function show(Practical $category)
    {
        return view('category.list',compact('category'));
    }
	public function practicalList()
    {
		$get_categories = Practical::orderBy('id','DESC')->get();
            return datatables()->of($get_categories)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                return '
				<a href="' . route('category.edit',$data->id) . '" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
				<a href="' . route('category.delete',$data->id) . '" class="btn btn-danger shadow btn-xs sharp" onClick="return confirm_click()"><i class="fa fa-trash"></i></a>';
			})
                ->rawColumns(['action'])
                ->make(true);
    }
}
