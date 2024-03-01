<?php
	
	namespace App\Http\Controllers\Admin;
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;
	use App\Models\User;
	use App\Admin;
	use Mail;
	
	class HomeController extends Controller
	{
		
		public function __construct()
		{
			$this->middleware('admin');
		}
		
		public function index()
		{
			$login_id = auth()->guard('admin')->user()->id; 
			$user = Admin::where('id',$login_id)->first();
			
			$user_email = $user->email;
			
			$email = 'sateesh4chk@gmail.com';
			
			Mail::send('admin.email.myTestMail', ['name'=> $user->name, 'email'=> $email], function ($message) use ($email, $user_email)
			{
				$message->from($user_email);
				$message->to($email);
				$message->subject('This is for testing email using smtp');
			});
			
			$total_user = User::count();
			return view('admin.home',compact('total_user'));
		}	
	}
