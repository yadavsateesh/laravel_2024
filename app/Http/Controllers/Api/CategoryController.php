<?php
	
	namespace App\Http\Controllers\Api;
	use App\Http\Controllers\Controller;
	use App\Models\Category;
	use Illuminate\Http\Request;
	
	
	class CategoryController extends Controller
	{
		public function getCategory(Request $request)
		{	
			$get_categories = Category::where('status',1)->orderBy('id','asc')->get();
			
			if($get_categories->count() > 0)
			{
				
				return response()->json(['success' => true, 'message' => 'Get Category Successfully', 'data' => $get_categories], 200);
			}
			else
			{
				return Response::json(['result' => 'failure', 'message'=> 'data not found'], 200);
			}
		}
		
		public function getCategorybyid(Request $request)
		{	
			$user_id = $request->id;
			
			$get_categories = Category::where('id',$user_id)->get();
			
			if($get_categories->count() > 0)
			{
				
				return response()->json(['success' => true, 'message' => 'Get Category Successfully', 'data' => $get_categories], 200);
			}
			else
			{
				return response()->json(['result' => 'failure', 'message'=> 'data not found'], 406);
			}
		}
	}
