<?php
	
	namespace App\Http\Controllers\Api;
	use App\Http\Controllers\Controller;
	use App\Models\SubCategory;
	use Illuminate\Http\Request;
	
	class SubCategoryController extends Controller
	{
		public function getSubCategory(Request $request)
		{	
			$get_subcategories = SubCategory::where('status',1)->get();
			
			if($get_subcategories->count() > 0)
			{
				
				return response()->json(['success' => true, 'message' => 'Get Category Successfully', 'data' => $get_subcategories], 200);
			}
			else
			{
				return Response::json(['result' => 'failure', 'message'=> 'data not found'], 200);
			}
		}
		
		public function getByidSubCategory(Request $request)
		{	
			$subcategories_id = $request->id;
			
			$get_subcategories = SubCategory::where('id',$subcategories_id)->get();
			
			if($get_subcategories->count() > 0)
			{
				
				return response()->json(['success' => true, 'message' => 'Get Category Successfully', 'data' => $get_subcategories], 200);
			}
			else
			{
				return Response::json(['result' => 'failure', 'message'=> 'data not found'], 200);
			}
		}
	}
