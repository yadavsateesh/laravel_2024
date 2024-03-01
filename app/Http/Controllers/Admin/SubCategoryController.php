<?php
	
	namespace App\Http\Controllers\Admin;
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;
	use App\Models\SubCategory;
	use App\Models\Category;
	
	class SubCategoryController extends Controller
	{
		public function __construct()
		{
			$this->middleware('admin');
		} 
		
		public function index()
		{
			return view('admin.subcategory.list');
		}
		public function subcategoryList()
		{
			
			$subcategory = SubCategory::orderBy('id','DESC')->get();
			
			return datatables()->of($subcategory)
            ->addIndexColumn()
			->addColumn('checkbox', function ($data) {
                return '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input subcategory-checkbox" name="subcategory_id[]" id="customCheckBox'.$data->id.'" value="'.$data->id.'" data-id="'.$data->id.'"><label class="custom-control-label" for="customCheckBox'.$data->id.'"></label></div>';
			})
            ->editColumn('status', function($data){
                return $data->status == 1 ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>';
			})
			->editColumn('created_at', function($data){
                return date('Y-m-d H:i:s', strtotime($data->created_at));
			})
			->addColumn('category', function($data){
				$category = Category::where('id', $data->category_id)->first();
                return $category->name;
			})
            ->addColumn('action', function($data){
                return '
				<a href="' . route('subcategory.edit',$data->id) . '" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
				<a href="' . route('subcategory.delete',$data->id) . '" class="btn btn-danger shadow btn-xs sharp" onClick="return confirm_click()"><i class="fa fa-trash"></i></a>';
			})
			->rawColumns(['checkbox','status', 'action'])
			->make(true);
		}
		public function create()
		{
			$category = Category::all();
			return view('admin.subcategory.create', compact('category'));
		}
		
		//store
		public function store(Request $request)
		{   
			$data = $request->validate([
			'category_id' => 'required',
			'subcategory_name' => 'required',
			],
			[	
			'category_id.required' =>('Category field is required'),
			'subcategory_name.required' => ('Name field is required'),
			]);
			
			$subcategory = new SubCategory();
			$subcategory->category_id = $request->category_id;
			$subcategory->subcategory_name = $request->subcategory_name;
			$subcategory->save();
			
			return redirect()->route('subcategory.index')->with('success', 'Subcategory added successfully');
		}
		
		//load edit page
		public function edit(SubCategory $subcategory)
		{	
			$category = Category::all();
			return view('admin.subcategory.edit', compact('subcategory','category'));
		}
		//update
		public function update(Request $request, SubCategory $subcategory)
		{
			$data = $request->validate([
			'category_id' => 'required',
			'subcategory_name' => 'required',
			],
			[	
			'category_id.required' =>('Category field is required'),
			'subcategory_name.required' =>('Name field is required'),
			]);
			
			$subcategory = SubCategory::find($subcategory->id);
			$subcategory->category_id = $request->category_id;
			$subcategory->subcategory_name = $request->subcategory_name;
			$subcategory->status = $request->status;
			$subcategory->save();
			
			return redirect()->route('subcategory.index')->with('success', 'Subcategory updated successfully');
		}
		
		//delete
		public function delete($id)
		{
			$subcategory = SubCategory::find($id);
			$subcategory->delete();
			
			return redirect()->route('subcategory.index')->with('success', 'Subcategory deleted successfully');
		}
		
		public function allDelete(Request $request)
		{
			foreach($request->id as $value){
				
				$subcategory = SubCategory::find($value);
				$subcategory->delete();
			}
			
			return redirect()->route('subcategory.index')->with('success', 'Subcategory deleted successfully');
		}
	}
