<?php

namespace App\Http\Controllers;

use App\Mail\websitemail;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    public function VendorLogin(){
        return view('vendor.login');
    }

    public function VendorRegister(){
        return view('vendor.register');
    }

    public function VendorRegisterSubmit(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'email' => ['required', 'string', 'unique:vendors'],
        ]);

        Vendor::insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'role' => 'client',
            'status' => '0',
        ]);

        $notification = array(
            'message' => 'Vendor Register Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('vendor.login')->with($notification);
    }

    public function VendorLoginSubmit(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $check = $request->all();

        $data = [
            'email' => $check['email'],
            'password' => $check['password'],
        ];

        if(Auth::guard('vendor')->attempt($data)){
            return redirect()->route('vendor.dashboard')->with('success', 'Client Successfully Logged In!');
        }else{
            return redirect()->route('vendor.login')->with('error', 'Invalid Credentials!');
        }
    }

    public function vendorLogout(){
        Auth::guard('vendor')->logout();
        return redirect()->route('vendor.login')->with('success', 'Logout Successfully!');
    }

    public function VendorDashboard(){
        return view('vendor.index');
    }

    public function VendorForgetPassword(){
        return view('vendor.forgetPassword');
    }

    public function VendorPasswordSubmit(Request $request){
        $request->validate([
            'email' => 'required|email'
        ]);

        $vendor_data = Vendor::where('email', $request->email)->first();
        if (!$vendor_data) {
            return redirect()->back()->with('error', 'Email not Found');
        }

        $token = hash('sha256', time());
        $vendor_data->token = $token;
        $vendor_data->update();

        $reset_link = url('vendor/reset_password/'.$token.'/'.$request->email);
        $subject = "Reset Password";
        $message = "Please Click on below link to reset password<br>";
        $message .= "<a href='".$reset_link."'>Click Here</a>";

        \Mail::to($request->email)->send(new websitemail($subject, $message));
        return redirect()->back()->with('success', 'Reset Password link send on your Email.');
    }

    public function VendorResetPassword($token, $email){
        $vendor_data = Vendor::where('email', $email)->where('token', $token)->first();
        if(!$vendor_data){
            return redirect()->route('vendor.login')->with('error', 'Invalid Token or Email');
        }
        return view('vendor.reset_password', compact('token', 'email'));
    }

    public function VendorResetPasswordSubmit(Request $request){
        // return $request->all();
        $request->validate([
            'password' => 'required',
            'password_confirmation' => 'required|same:password'
        ]);

        $vendor_data = Vendor::where('email', $request->email)
        ->where('token', $request->token)->first();

        $vendor_data->password = Hash::make($request->password);
        $vendor_data->token = "";
        $vendor_data->update();

        return redirect()->route('vendor.login')->with('success', 'Password Reset Successful.');
    }

    public function VendorProfile(){
        $id = Auth::guard('vendor')->id();
        $profileData = Vendor::find($id);

        return view('vendor.vendor_profile', compact('profileData'));
    }

    public function VendorProfileStore(Request $request){
        $id = Auth::guard('vendor')->id();
        $data = Vendor::find($id);

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $oldPhotoPath = $data->photo;

        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('upload/vendor_images'), $filename);
            $data->photo = $filename;

            if ($oldPhotoPath && $oldPhotoPath !== $filename){
                $this->deleteOldImage($oldPhotoPath);
            }
        }
        $data->save();
        $notification = array(
            'message' => 'Profile Update Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    private function deleteOldImage(string $oldPhotoPath):void{
        $fullPath = public_path('upload/vendor_images/'.$oldPhotoPath);

        if(file_exists($fullPath)){
            unlink($fullPath);
        }
    }
}
