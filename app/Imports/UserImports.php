<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UserImports implements ToModel, 
                            WithHeadingRow,
                            SkipsOnError, 
                            WithValidation,
                            SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;
    public function model(array $row)
    {
        $user = new User([
            'name' => $row["ho_va_ten"], 
            'username' => $row['ten_dang_nhap'],
            'email' => $row['email'],
            'password' => Hash::make($row['mat_khau']),
            'academic_year' => $row["nien_khoa"],
            'role' => $row['vai_tro'],
        ]);

        DB::table('model_has_roles')->where('model_id',$user->id)->delete();
        $user->assignRole($user->role);

        return $user;
    }

    public function rules():array {
        return [
            'ho_va_ten' => 'required',
            'ten_dang_nhap' => 'required|unique:users,username',
            'email' => 'sometimes|nullable|email|unique:users,email',
            'mat_khau' => 'required|min:6',
            'vai_tro' => ['required', Rule::exists('roles', 'id'),],
        ];
    }

    public function customValidationMessages(){
        return [
            'ho_va_ten.required' => "':attribute' thiếu",
            'ten_dang_nhap.unique' => "':attribute' đã tồn tại",
            'ten_dang_nhap.required' => "':attribute' thiếu",
            'email.unique' => "':attribute' đã tồn tại",
            'email.email' => "':attribute' sai định dạng",
            'mat_khau.required' => "':attribute' thiếu",
            'mat_khau.min' => "':attribute' ít hơn 6 ký tự",
            'vai_tro.required' => "':attribute' thiếu",
            'vai_tro.exists' => "':attribute' không tồn tại",
        ];
    }

    public function customValidationAttributes(){
        return [
            'ho_va_ten' => 'Họ và tên',
            'ten_dang_nhap' => 'Tên đăng nhập',
            'email' => 'Email',
            'mat_khau' => 'Mật khẩu',
            'vai_tro' => 'Vai trò',
        ];
    }
}
