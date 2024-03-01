<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
        public function __construct()
    {
        $this->middleware('admin');
    }
	
    public function index()
    {
        return view('admin.profile.edit');
    }
	
	public function update(Request $request)
    {
		$admin_id = auth()->guard('admin')->user()->id;
		
        $data = $request->validate([
            'name' => 'required|regex:/^[a-zA-Z\s]+$/',
			'email' => "required|email|unique:admins,email,$admin_id,id",
        ]);
		
        $admin = Admin::find($admin_id);
		$admin->name = $request->name;
		$admin->email = $request->email;
		$admin->save();
		
        return redirect()->route('admin.profile')->with('success', 'Admin detail updated successfully');
    }
	
	public function changePasswordUpdate(Request $request)
    {
        $admin_id = auth()->guard('admin')->user()->id;
		
        $data = $request->validate([
            'password' => "required|min:5",
            'confirm_password' => "required|same:password",
        ]);

        $admin = Admin::find($admin_id);
		$admin->password = Hash::make($request->password);
		$admin->save();

         return redirect()->back()->with('success', 'your message,here'); 
    } 
}
