<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\Research;
use App\Models\User;
use App\Models\Topic;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Auth;
use Illuminate\Support\Arr;
use Brian2694\Toastr\Facades\Toastr;
use App\Imports\UserImports;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->middleware('permission:user-list', ['only' => ['index']]);
    }

    public function index(Request $request)
    {
        $param = $request->all();
        $users = User::orderBy('role', 'ASC')->orderBy('id', 'ASC');
        if (Auth::user()->can('user-list')) {
            $users->where('role', ">", Auth::user()->role)->withCount('topics');
        }

        if(!empty($request->role)){
            $users->where('role', $request->role);
        }

        if(!empty(trim($request->keyword))){
            $kw = trim($request->keyword);
            $users->where(function($query) use ($kw){
                $query->orWhere('name','like','%'.$kw.'%');
                $query->orWhere('username','like','%'.$kw.'%');
            });
        }

        $users = $users->paginate(10)->appends($param);

        $roles = Role::where('id', ">", Auth::user()->role)->pluck('name', 'id')->all();

        return view('users.index', compact('users', 'roles'))
            ->with('i', ($request->input('page', 1) - 1) * 10);
        // $topics = Topic::all();
        // echo $topics;
    }

    public function create()
    {
        $roles = Role::where('id', ">", Auth::user()->role)->pluck('name', 'id')->all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required|unique:users|alpha_dash',
            'email' => 'sometimes|nullable|email|unique:users,email',
            'password' => 'required|min:6|same:confirm-password',
            'roles' => ['required', 
                        Rule::exists('roles', 'id'),    
                    ],
        ],
        
        [
            'required' => ':attribute không được để trống',
            'unique' => ':attribute đã tồn tại trên hệ thống',
            'same' => ':attribute và :attribute xác nhận phải khớp nhau',
            'min' => ':attribute phải lớn hơn :min ký tự',
            'exists' => ':attribute không tồn tại',
        ],
        
        [
            'name' => 'Họ và tên',
            'username' => "Tên đăng nhập",
            'email' => "Email",
            'password' => 'Mật khẩu',
            'roles' => 'Quyền',
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['role'] = $input['roles'][0];
        if($input['role'] == 5){
            $input['academic_year'] = DB::table('configurations')
                                        ->select('academic_year')
                                        ->first()->academic_year;
        }
        if (Auth::user()->role >= intval($input['role'])) {
            Toastr::error("Bạn không thể gắn quyền với quyền lớn hơn.");
            return back()->withInput();
        }
        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'Tạo tài khoản thành công');
    }

    public function show(User $user)
    {
        $topics = Topic::where('user_id', $user->id)->paginate(10);
        $param = ['user_id' => $user->id];
        return view('users.show', compact('user', 'param', 'topics'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::where('id', ">", Auth::user()->role)->pluck('name', 'id')->all();
        $userRole = $user->roles->pluck('id', 'id')->all();
        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $id . '|alpha_dash',
            'email' => 'sometimes|nullable|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => ['required', Rule::exists('roles', 'id')],
        ],
        
        [
            'required' => ':attribute không được để trống',
            'unique' => ':attribute đã tồn tại trên hệ thống',
            'same' => ':attribute và :attribute xác nhận phải khớp nhau',
            'min' => ':attribute phải lớn hơn :min ký tự',
            'exists' => ':attribute không tồn tại',
        ],
        
        [
            'name' => 'Họ và tên',
            'username' => "Tên đăng nhập",
            'email' => "Email",
            'password' => 'Mật khẩu',
            'roles' => 'Quyền',
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $input['role'] = $input['roles'][0];
        
        if($input['role'] == 5){
            $input['academic_year'] = DB::table('configurations')
                                        ->select('academic_year')
                                        ->first()->academic_year;
        }
        if (Auth::user()->role >= intval($input['role'])) {
            Toastr::error("Bạn không thể gắn quyền với quyền lớn hơn.");
            return back()->withInput();
        }
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'Cập nhập tài khoản thành công');
    }

    public function destroy($id)
    {
        // User::find($id)->delete();
        // dd($_REQUEST->all());
        DB::table('users')->where('id', $id)->delete();
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        DB::table('user_register_topics')->where('user_id', $id)->delete();
        return redirect()->back()
            ->with('success', 'Xóa tài khoản thành công');
    }

    public function showListUser() {
        $users = DB::table('users')->get();
        return $users;
    }
    
    public function importUsers()
    {
        return view('users.import');
    }

    public function uploadUsers(Request $request)
    {
        if(!$request->file){
            return view('users.import')->with('error', 'Vui lòng chọn file!!!');
        }

        $file  = $request->file;
        $extension = $file->getClientOriginalExtension();
        if($extension != 'xlsx'){
            return view('users.import')->with('error', 'Vui lòng chọn file có đuôi .xlsx!!!');
        }

        $import = new UserImports();
        $importArr = reset($import->toArray($file)[0]);
        if(!isset($importArr["ho_va_ten"]) || !isset($importArr["ten_dang_nhap"]) 
        || !isset($importArr["email"]) || !isset($importArr["mat_khau"]) 
        || !isset($importArr["nien_khoa"]) || !isset($importArr["vai_tro"])){
            return view('users.import')->with('error', 'Vui lòng chọn file theo đúng định dạng!!!');
        }


        $import->import($file);
    
        
        
        return view('users.import', [
            'listUserImport' => $import->toArray($file),
            'failures' => $import->failures(),
            'row' => 1
        ])->with('success', 'Tải lên hoàn tất!!!');
    }
}
