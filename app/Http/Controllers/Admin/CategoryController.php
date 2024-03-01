<?php
	
	namespace App\Http\Controllers\Admin;
	use App\Http\Controllers\Controller;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Http\Request;
	use App\Models\Category;
	
	class CategoryController extends Controller
	{
		public function __construct()
		{
			$this->middleware('admin');
		} 
		
		public function index()
		{
			return view('admin.category.list');
		}
		
		//List Data
		public function categoryList()
		{
			//echo"hii";die;
			$get_categories = Category::orderBy('id','DESC')->get();
			
			return datatables()->of($get_categories)
            ->addIndexColumn()
			->addColumn('checkbox', function ($data) {
                return '<div class="custom-control custom-checkbox "><input type="checkbox" class="custom-control-input category-checkbox" name="id" id="customCheckBox'.$data->id.'" value="'.$data->id.'" data-id="'.$data->id.'"><label class="custom-control-label" for="customCheckBox'.$data->id.'"></label></div>';
			})
            ->editColumn('status', function($data){
                return $data->status == 1 ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>';
			})
			->editColumn('created_at', function($data){
                return date('Y-m-d H:i:s', strtotime($data->created_at));
			})
            ->addColumn('action', function($data){
                return '
				<a href="' . route('category.edit',$data->id) . '" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
				<a href="' . route('category.delete',$data->id) . '" class="btn btn-danger shadow btn-xs sharp" onClick="return confirm_click()"><i class="fa fa-trash"></i></a>';
			})
			->rawColumns(['checkbox','status', 'action'])
			->make(true);
		}
		
		public function create()
		{
			return view('admin.category.create');
		}
		
		//store.
		public function store(Request $request)
		{   
			$data = $request->validate([
			'category_name' => 'required',
			],
			[
			'category_name.required' =>('Name field is required'),
			]);
			
			$category = $request->category_name;
			
			foreach ($category as $key => $category_name) {
				$category = new Category();
				$category->category_name = $category_name;
				$category->save();
			}
			
			return redirect()->route('category.index')->with('success', 'Category added successfully');
		}
		
		//edit page relode.
		public function edit(Category $category)
		{
			return view('admin.category.edit', compact('category'));
		}
		
		//updete.
		public function update(Request $request, Category $category)
		{
			$data = $request->validate([
			'category_name' => 'required',
			],
			[
			'category_name.required' =>'Name field is required',
			]);
			
			$category = Category::find($category->id);
			$category->category_name = $request->category_name;
			$category->status = $request->status;
			$category->save();
			
			return redirect()->route('category.index')->with('success', 'Category updated successfully');
		}
		
		//delete.
		public function delete($id)
		{
			$category = Category::find($id);
			$category->delete();
			
			return redirect()->route('category.index')->with('success', 'Category deleted successfully');
		}
		
		//multiple delete.
		public function deleteAll(Request $request)
		{		
			foreach($request->id as $value){
				$category = Category::find($value);
				$category->delete();
				
			}
			return redirect()->route('category.index')->with('success', 'Category deleted successfully');
			
		}
		
		public function show ($id)
		{
			$category = Category::find($id);
			$category->delete();
			
			return redirect()->route('category.index')->with('success', 'Category deleted successfully');
		}
		/* //status Active and inActive.
			public function status(Request $request)
			{
			$ids = $request->input('ids');
			
			foreach ($ids as $id) {
			$asset = Category::where('id', $id)->first();
			if ($request->type == 'active') {
			$asset->status = $request->status;
			}
			if ($request->type == 'inactive') {
			$asset->status = $request->status;
			}
			$asset->save();
			}
			
			return redirect()->route('category.index')->with('success', 'Status Change successfully');
		} */
	}
