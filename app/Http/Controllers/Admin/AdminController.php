<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Auth;
use Validator;
use Hash;
use Intervention\Image\Facades\Image;
use Session;




class AdminController extends Controller
{
    public function dashboard()
    {
        Session::put('page', 'dashboard');
        return view('admin.dashboard');
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required|max:30'
            ];
            $customMessages = [
                'email.required' => "Email is required",
                'email.email' => "Email is not valid",
                'email.max' => "Email is too long",
                'password.required' => "Password is required",

            ];
            $this->validate($request, $rules, $customMessages);


            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                return redirect("admin/dashboard");
            } else {
                return redirect()->back()->with("error_message", "Invalid Email or Password");
            }
        }
        return view('admin.login');
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
    public function updatePassword(Request $request)
    {
        Session::put('page', 'update-password');
        if ($request->isMethod('post')) {
            $data = $request->all();
            if (Hash::check($data['current_Pwd'], Auth::guard('admin')->user()->password)) {
                if ($data['new_pwd'] == $data['confirm_pwd']) {
                    Admin::where('id', Auth::guard('admin')->user()->id)
                        ->update(['password' => bcrypt($data['new_pwd'])]);
                    return redirect()->back()->with("success_message", "New password is updated successfully.");

                } else {
                    return redirect()->back()->with("error_message", "New password and confirm password do not match");
                }
            } else {
                return redirect()->back()->with("error_message", "Current password is incorrect");
            }
        }
        return view('admin.update_password');

    }
    public function checkCurrentPassword(Request $request)
    {
        // echo "inside checkCurrentPassword ....";
        $data = $request->all();
        if (Hash::check($data['current_Pwd'], Auth::guard('admin')->user()->password)) {
            // echo "return true ...";
            return "true";
        } else {
            // echo "return false ...";
            return "false";
        }
    }
    public function updateAdminDetails(Request $request)
    {
        Session::put('page', 'update-details');
        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'admin_mobile' => 'required|numeric|digits:10',
                'admin_image' => 'image',
            ];
            $customMessages = [
                'admin_name.required' => "Name is required",
                'admin_name.regex' => "Valid Name is required",
                'admin_name.max' => "Valid Name is required",
                'admin_mobile.required' => "Mobile is required",
                'admin_mobile.numeric' => "Valid mobile is required",
                'admin_mobile.digits' => "Valid mobile is required",
                'admin_image.image' => "Valid image is required",


            ];
            $this->validate($request, $rules, $customMessages);
            $imageName = '';
            if ($request->hasFile('admin_image')) {
                $image_tmp = $request->file('admin_image');
                if ($image_tmp->isValid()) {
                    // Generate Random Image name  
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $image_tmp->move(public_path('admin/img/photos'), $imageName);
                    $imageUrl = 'admin/img/photos' . $imageName;
                }

            } else if (!empty($data['current_img'])) {
                $imageName = $data['current_img'];
            } else {
                $imageName = "";
            }

            Admin::where('email', auth::guard('admin')->user()->email)->update(
                ['name' => $data['admin_name'], 'mobile' => $data['admin_mobile'], 'image' => $imageName]
            );
            return redirect()->back()->with("success_message", "Admin Details updated successfully.");

        }
        return view('admin.update_details');
    }
}