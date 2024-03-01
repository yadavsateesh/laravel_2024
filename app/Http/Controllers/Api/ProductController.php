<?php
	
	namespace App\Http\Controllers\Api;
	use App\Http\Controllers\Controller;
	use App\Models\Product;
	
	use Illuminate\Http\Request;
	
	class ProductController extends Controller
	{
		public function getProduct(Request $request)
		{	
			$get_product = Product::where('status',1)->get();
			
			if($get_product->count() > 0)
			{
				
				return response()->json(['success' => true, 'message' => 'Get Category Successfully', 'data' => $get_product], 200);
			}
			else
			{
				return Response::json(['result' => 'failure', 'message'=> 'data not found'], 200);
			}
		}
		
		public function getByidProduct(Request $request)
		{	
			$product = $request->id;
			
			$product = Product::where('id',$product)->get();
			
			if($product->count() > 0)
			{
				
				return response()->json(['success' => true, 'message' => 'Get Category Successfully', 'data' => $product], 200);
			}
			else
			{
				return Response::json(['result' => 'failure', 'message'=> 'data not found'], 200);
			}
		}
	}
