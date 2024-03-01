<?php
	
	namespace App\Http\Controllers\Api;
	use App\Http\Controllers\Controller;
	use Illuminate\Support\Facades\Validator;
	use App\Models\User;
	use Hash;
	use Auth;
	
	use Illuminate\Http\Request;
	
	class AuthController extends Controller
	{
		public function register(Request $request)
		{
			$validator = Validator::make($request->all(), [
			
            'name' => 'required',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required', 
            'address' => 'required', 
            'mobile_no' => 'required', 
            'user_type' => 'required|string',
            'device_token' => 'required|string',
			]);
			
			if ($validator->fails())
			{
				
				$messages = $validator->errors()->messages();
				
				foreach ($messages as $key => $value)
				{
					$error = $value[0];
				}
				
				return response()->json(['success' => false, 'message' => $error], 406);
			}
			else
			{    
				$user = new User();
				$user->name = $request->name;
				$user->email = $request->email;
				$user->password = Hash::make($request->password);
				$user->user_type = $request->user_type;
				$user->address = $request->address;
				$user->mobile_no = $request->mobile_no;
				$user->device_token = $request->device_token;
				$user->user_session_token = Hash::make(rand(1111 , 9999).rand(1111 , 9999));
				$user->save();
				
				//$user->sendEmailVerificationNotification();
				
				unset($user->otp);
				
				return response()->json(['success' => true, 'message' => 'User Create Successfully', 'data' => $user], 200);
			}
		}
		
		/* public function login(Request $request)
			{
			$validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
			]);
			
			if ($validator->fails())
			{
			$messages = $validator->errors()->messages();
			
			foreach ($messages as $key => $value)
			{
			$error[] = $value[0];
			}
			
			return response()->json($error, 406);
			}
			else
			{
			if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) 
			{
			$user = User::find(Auth::guard('web')->user()->id);
			$user->user_session_token = Hash::make(rand(1111 , 9999).rand(1111 , 9999));
			$user->device_token = $request->device_token;
			$user->save();
			
			return response()->json(['message' => 'Login successfully', 'data' => $user], 200);
			//return response()->json(['message' => 'Login Successfully'], 200);
			}
			else
			{
			return response()->json(['Credentials Does not Match !'], 406);
			}
			}
		} */ 
		
		public function login(Request $request)
		{
			$validator = Validator::make($request->all(), [
            'mobile_no' => 'required',
			]);
			
			if ($validator->fails())
			{
				$messages = $validator->errors()->messages();
				
				foreach ($messages as $key => $value)
				{
					$error[] = $value[0];
				}
				
				return response()->json($error, 406);
			}
			else
			{
				$user = User:: where('mobile_no',$request->mobile_no)->first();
				
				if ($user) 
				{
					$user = User::find($user->id);
					$user->user_session_token = Hash::make(rand(1111 , 9999).rand(1111 , 9999));
					$user->device_token = $request->device_token;
					if(app()->environment('production')){
						$user->otp = rand(1111 , 9999);
					}
					else
					{
						$user->otp = '1234';
					}
					$user->is_otp_verified = '0';
					$user->save();
					
					return response()->json(['message' => 'Login successfully', 'data' => $user], 200);
					//return response()->json(['message' => 'Login Successfully'], 200);
				}
				else
				{
					$user = new User();
					$user->mobile_no = $request->mobile_no;
					$user->user_type = "user";
					$user->user_session_token = Hash::make(rand(1111 , 9999).rand(1111 , 9999));
					$user->device_token = $request->device_token;
					if(app()->environment('production')){
						$user->otp = rand(1111 , 9999);
					}
					else
					{
						$user->otp = '1234';
					}
					$user->is_otp_verified = '0';
					$user->save();
					
					return response()->json(['message' => 'User Create Successfully', 'data' => $user], 200);
				}
			}
		}
		
		public function logout(Request $request)
		{
			$user_id = $request->get('user_id');
			$user = User::find($user_id );
			if($user){
				
				$user->device_token = NULL;
				$user->user_session_token = NULL;
				$user->save();
				
				return response()->json(['message' => 'Logout successfully'], 200);
			}
		}
		
		public function verifyOtp(Request $request)
		{
			$validator = Validator::make($request->all(), [
            'mobile_no' => 'required',
            'otp' => 'required',
			]);
			
			if ($validator->fails())
			{
				$messages = $validator->errors()->messages();
				
				foreach ($messages as $key => $value)
				{
					$error[] = $value[0];
				}
				
				return response()->json($error, 406);
			}
			else
			{
				$user = User:: where(['mobile_no' =>$request->mobile_no,'otp' => $request->otp])->first();
				
				if ($user)
				{
					$user = User::find($user->id);
					$user->otp = NULL;
					$user->is_otp_verified = '1';
					$user->save();
					return response()->json(['message' => 'OTP Verify Successfully', 'data' => $user], 200);
				}
				else
				{
					return response()->json(['OTP Does not Match !'], 406);
				}
				
			}
		}
		
		public function editProfile(Request $request)
		{
			
			$user_id = $request->get('user_id');
			
			$validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'mobile_no' => 'required',
            'address' => 'required',
			]);
			
			if ($validator->fails())
			{
				$messages = $validator->errors()->messages();
				
				foreach ($messages as $key => $value)
				{
					$error[] = $value[0];
				}
				
				return response()->json($error, 406);
			}
			else 
			{
				$user = User::find($user_id);
				$user->name = $request->name;
				$user->email = $request->email;
				$user->mobile_no = $request->mobile_no;
				$user->address = $request->address;
				$user->save();
				
				$get_user = User::find($user_id);
				
				return response()->json(['message' => 'Profile Update Successfully', 'data' => $get_user], 200);
			}
			
		}
		
		function changePasswordUpdate(Request $request)
		{
			$user_id = $request->get('user_id');
			$user = User::find($user_id);
			
			if (!Hash::check($request->old_password, $user->password))
			{
				return response()->json(['success' => false, 'message' => 'The old password does not match our records.']);
			}
			
			$user->password = Hash::make($request->new_password);
			$user->save();
			
			return response()->json(['message' => 'Password change Successfully'], 200);
		}
		
		function getUserDetails(Request $request)
		{
			$user_id = $request->get('user_id');
			$get_user = User::where('id',$user_id)->first();
			
			return response()->json(['message' => 'Get Profile User Details Successfully', 'data' => $get_user], 200);
		}
	}
