<?php
	namespace App\Http\Controllers\Admin;
	use App\Http\Controllers\Controller;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Http\Request;
	use App\Models\Product;
	use App\Models\Category;
	use App\Models\SubCategory;
	use App\Models\ProductImage;
	use Str;
	use Storage;
	use Image;
	use File;
	use App\Exports\AdminExport;
	use App\Imports\AdminImport;
	use Maatwebsite\Excel\Facades\Excel;
	use PDF;
	
	class ProductController extends Controller
	{
		public function __construct()
		{
			$this->middleware('admin');
		} 
		
		public function index()
		{
			return view('admin.product.list');
		}
		
		//List Data
		public function productList()
		{
			//echo"hii";die;
			$get_product = Product::orderBy('id','DESC')->get();
			
			return datatables()->of($get_product)
            ->addIndexColumn()
			->addColumn('checkbox', function ($data) {
                return '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input product-checkbox select-status-checkbox" name="product_id[]" id="customCheckBox'.$data->id.'" value="'.$data->id.'" data-id="'.$data->id.'"><label class="custom-control-label" for="customCheckBox'.$data->id.'"></label></div>';
				
			})
            ->editColumn('status', function($data){
                return $data->status == 1 ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>';
			})
			->editColumn('created_at', function($data){
                return date('Y-m-d H:i:s', strtotime($data->created_at));
			})
			->addColumn('category', function($data){
				$category = Category::where('id', $data->category_id)->first();
                return $category->category_name;
			})
			->addColumn('subcategory', function($data){
				$subcategory = SubCategory::whereIn('id', explode(',',$data->subcategory_id))->get();
				$subcategory = $subcategory->toArray();
				$subcategory_name = array_column($subcategory,'subcategory_name');
                return implode(',',$subcategory_name);
			})
            ->addColumn('action', function($data){
				
				$user_status = ($data->is_block == 1) ? '<a href="' . route('product.change-status',[$data->id,'no_block']) . '" class="verified btn btn-danger shadow btn-xs sharp mr-1" onclick="return confirm("Are you sure you want to unverified this property ?");"><i class="fa fa-fw fa-unlock"></i></a>' : '<a href="' . route('product.change-status',[$data->id,'block']) . '" class="btn btn-primary shadow btn-xs sharp mr-1 icon__2" onclick="return confirm("Are you sure you want to block this product ?");"><i class="fa fa-fw fa-lock"></i></a>';
				
                return '
				<a href="' . route('product.edit',$data->id) . '" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
				<a href="' . route('product.delete',$data->id) . '" class="btn btn-danger shadow btn-xs sharp" onClick="return confirm_click()"><i class="fa fa-trash"></i></a><a href="' . route('product.show',$data->id) . '" class="btn btn-success shadow btn-xs sharp mr-1 icon__3"><i class="fa fa-eye"></i></a>'.$user_status;
			})
			
			->editColumn('is_block', function($data){
				return $data->is_block == 1 ? '<span class="label label-danger">Block</span>' : '<span class="label label-success">Unblock</span>';
			})
			->rawColumns(['checkbox','is_block','status', 'action'])
			->make(true);
		}
		
		public function create()
		{
			$category = Category::all();
			$subcategory = SubCategory::all();
			return view('admin.product.create' , compact('category','subcategory'));
		}
		
		//store.
		public function store(Request $request)
		{    
			$data = $request->validate([
			'category_id' => 'required',
			'subcategory_id' => 'required',
			'product_name' => 'required',
			'image' => 'required',
			],
			[
			'category_id.required' =>'Category field is required',
			'subcategory_id.required' =>'SubCategory field is required',
			'product_name.required' =>'Name field is required',
			'image.required' =>'image field is required',
			]);
			
			$product = $request->product_name;
			foreach($product as $key => $id){
				$product = new Product();
				$product->category_id = $request->category_id;
				$product->subcategory_id = implode(',',$request->subcategory_id);
				$product->product_name = $id;
				$product->save();
				$product->id; 
				
				foreach($request->file('image') as $image){
					$randum_image_name = Str::uuid();
					$image_name = $randum_image_name . '.' . $image->getClientOriginalExtension();
					$image->storeAs('public/product', $image_name);
					$imagepath = asset('storage/product/'. $image_name); 
					
					$image = Image::make($imagepath);
					$image->encode('webp', 75)->save(public_path('storage/product/' . pathinfo($image_name, PATHINFO_FILENAME) . '.webp'));
					$image_webp = $randum_image_name. '.webp';
					
					//insert image
					$image = new ProductImage();
					$image->product_id = $product->id;
					$image->image = $image_webp;
					$image->save();
					
					$ext = pathinfo($image_name, PATHINFO_EXTENSION);
					
					
					if ($ext == 'jpg')
					{	
						//$return = unlink($image_name);
						/*  File::delete('public/storage/product/' . $image_name);
						$image->delete(); */
					}
				}
			}
			
			return redirect()->route('product.index')->with('success', 'Product added successfully');
		}
		
		//edit page relode.
		public function edit(Product $product)
		{	
			$category = Category::all();
			$subcategory = SubCategory::where('category_id', $product->category_id)->get();
			
			//$image = Image::all();
			$images = ProductImage::where('product_id', $product->id)->get();
			
			$images = $images->toArray(); 
			
			return view('admin.product.edit', compact('product','category','subcategory','images'));
		}
		
		//updete.
		public function update(Request $request, Product $product)
		{
			$data = $request->validate([
			'product_name' => 'required',
			'category_id' => 'required',
			'subcategory_id' => 'required',
			],
			[
			'product_name.required' =>'Name field is required',
			'category_id.required' =>'Category field is required',
			'subcategory_id.required' =>'SubCategory field is required',
			]);
			
			$product = Product::find($product->id);
			$product->category_id = $request->category_id;
			$product->subcategory_id = implode(',',$request->subcategory_id);
			$product->product_name = $request->product_name;
			$product->status = $request->status;
			$product->save();
			$product->id; 
			
			if($request->file('image')){
				foreach($request->file('image') as $image){
					$image_name = Str::uuid() . '.' . $image->getClientOriginalExtension();
					$image->storeAs('public/product', $image_name);
					$imagepath = asset('public/storage/product/'. $image_name); 
					
					//insert image
					$image = new ProductImage();
					$image->product_id = $product->id;
					$image->image = $image_name;
					$image->save();
					
				}
			} 
			
			return redirect()->route('product.index')->with('success', 'Product updated successfully'); 
		}
		
		//delete.
		public function delete($id)
		{
			$product = Product::find($id);
			$product->delete();
			
			return redirect()->route('product.index')->with('success', 'Product deleted successfully');
		} 
		//delete.
		public function show($id)
		{
			//$product = Product::where('id',$id)->get();
			$product = Product::select('products.*','categories.id','categories.category_name','categories.status','sub_categories.subcategory_name','sub_categories.status','sub_categories.id')
			->join('categories', 'categories.id', '=', 'products.category_id')
			->join('sub_categories', 'sub_categories.id', '=', 'products.subcategory_id')
			->where(['products.id' => $id])->get();
			
			return view('admin.product.view', compact('product'));
		} 
		
		//image delete.
		public function imageDelete($id)
		{
			$image = ProductImage::find($id);
			
			if ($image->image)
			{
				Storage::delete('public/product/' . $image->image);
				$image->delete();
			}
			
			return redirect()->route('product.edit',$image->product_id)->with('success', 'Image deleted successfully');
		}
		
		//getSubcategory dropdown.
		public function getSubcategory(Request $request)
		{
			$category_id = $request->input('category_id');
			$subcategory = SubCategory::where('category_id', $category_id)->orderBy('subcategory_name', 'ASC')->get();
			
			$subcategory_html = "<option disabled value=''>Choose...</option>";
			
			foreach ($subcategory as $value)
			{
				$subcategory_html .= "<option value='" . $value['id'] . "'>" . $value['subcategory_name'] . "</option>";
			}
			echo $subcategory_html;  
			
		} 
		
		public function userBlock($id,$status)
		{
			$user = Product::find($id);
			
			if($status == 'block')
			{
				$user->is_block = '1';
				$user->save();
			}
			else
			{
				$user->is_block = '0';
				$user->save();
			}
			
			return redirect()->back()->with('success', 'Product updated successfully.');   
		}
		
		public function export() 
		{
			return Excel::download(new AdminExport, 'admin.xlsx');
		}
		
		public function import() 
		{
			Excel::import(new AdminImport,request()->file('file'));
			
			return back();
		}
		
		public function generatePDF($id)
		{
			$product = Product::where('id',$id)->get();
			//view()->share('employee',$product);
			
			//$pdf = PDF::loadView('admin.product.view', compact('product'));
			$pdf = PDF::loadView('admin.product.view', compact('product'))->setOptions(['defaultFont' => 'sans-serif']);
			
			return $pdf->download('shoping-mall.pdf');
		}
		
		//delete.
		public function productOrder(Request $request)
		{
			
			$category = Category::where('status', 1)->orderBy('id','ASC')->get();
			$category_id ="";
			if ($request->isMethod('post')) 
			{
				$data = $request->validate([
                'category_id' => 'required',
				]);
				$product = Product::where('category_id', $data['category_id'])->orderBy('order')->get();
				$category_id= $data['category_id'];
			} 
			else 
			{
				$data = [];
				$product = [];
			}
			return view('admin.product.product-order',compact('category','product','category_id'));
			
		} 
		
		//saveOrder
		public function saveOrder(Request $request)
		{
			//echo "hi";die;
			foreach($request->row_order as $key => $id) {
				$key++;
				$data = Product::where('id', $id)->first();
				$data->order = $key;
				$data->save(); 
			}
			//return redirect()->back()->with('success', 'product ordered successfully.');   
			return redirect()->route('product.index')->with('success', 'Product ordered successfully');
		}
		
		public function deleteAll(Request $request)
		{
			foreach($request->id as $value)
			{
				$product = Product::find($value);
				$product->delete();
			}
			return redirect()->route('product.index')->with('success', 'Product delete successfully');
		}
		
		//status Active and inActive.
		public function status(Request $request)
		{
			$ids = $request->input('id');
			
			foreach ($ids as $id) {
				$product = Product::where('id', $id)->first();
				if ($request->type == 'active') {
					$product->status = $request->status;
				}
				if ($request->type == 'inactive') {
					$product->status = $request->status;
				}
				$product->save();
			}
			
			return redirect()->back()->with('success', 'Status Change successfully');
		}
	}
