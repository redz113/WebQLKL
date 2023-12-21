<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Models\Topic;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // return view('home');
        $user = Auth::user();
        {
            if (($user->password_change_at == null)) {
                return redirect(route('changePassword'));
            } else {
                return view('home.index', ['user' => $user]);
            }
        }
    }

    public function showChangePasswordForm()
    {
        return view('auth.passwords.changepassword');
    }

    public function changePassword(Request $request)
    {

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->withErrors(["current-password" => "Mật khẩu hiện tại không đúng. Vui lòng kiểm tra lại!"]);
        }

        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            //Current password and new password are same
            return redirect()->back()->withErrors(["new-password" => "Mật khẩu mới không được trùng với mật khẩu hiện tại. Vui lòng chọn mật khẩu khác!"]);
        }

        if (strcmp($request->get('new-password'), $request->get('new-password-confirmation')) != 0) {
            //Current password and new password are same
            return redirect()->back()->withErrors(["new-password-confirmation" => "Mật khẩu xác nhận không khớp với mật khẩu mới. Vui lòng nhập lại mật khẩu xác nhận!"]);
        }

        $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6',
            'new-password-confirmation' => 'required|string|min:6'
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->password_change_at = \Carbon\Carbon::now();
        $user->save();
        Toastr::success('Thay đổi mật khẩu thành công!');

        return redirect('/')->with("success", "Thay đổi mật khẩu thành công!");
    }
}
