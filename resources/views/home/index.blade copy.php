@extends('layouts.app')

@section('content')


<div class="card">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0">{{ __('HỆ THỐNG ĐĂNG KÝ KHÓA LUẬN TỐT NGHỆP CHO SINH VIÊN KHOA CNTT!') }}</h3>
            </div>
            <div class="col text-right">
                <a href="#!" class="btn btn-sm btn-primary">See all</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        
    </div>
</div>

<h4 class="mt-2"></h4>
<hr class="mb-0" />

<div class="row">
    @include('home.item', ['name'=>'Đăng ký', 'label' => 'Đề tài', 'link'=>'topics-register-list', 'image'=>'group.png', 'role'=>'topic-register'])
    @include('home.item', ['name'=>'Nhập dữ liệu', 'label' => 'Đề tài', 'link'=>'topics', 'role'=>'topic-list'])
    @include('home.item', ['name'=>'Quản lý', 'label' => 'Tài khoản', 'link'=>'users', 'role'=>'user-list', 'image'=>'user.png'])
    <!-- @include('home.item', ['name'=>'Nhập dữ liệu', 'label' => 'Xếp nhóm', 'link'=>'groups?type=2', 'image'=>'group.png', 'role'=>'group-list']) -->
    <!-- @include('home.item', ['name'=>'Đề tài', 'label' => 'Phê duyệt', 'link'=>'groups?type=1', 'image'=>'check.png', 'i'=>1, 'role'=>'file-edit'])
    @include('home.item', ['name'=>'Đề tài', 'label' => 'Nhập điểm', 'link'=>'examiners', 'image'=>'com.png', 'i'=>1, 'role'=>'examiner-point'])
    @include('home.item', ['name'=>'Đề tài', 'label' => 'Xếp giải', 'link'=>'groups?type=3', 'image'=>'ribbon.png', 'i'=>1, 'role'=>'medal-list'])
    @include('home.item', ['name'=>'Chung', 'label' => 'Đơn vị dự thi', 'link'=>'users?role=3', 'image'=>'user.png', 'i'=>0, 'role'=>'user-list'])
    @include('home.item', ['name'=>'Chung', 'label' => 'Kết quả', 'link'=>'reports', 'image'=>'print.png', 'i'=>0, 'role'=>'report'])
    @include('home.item', ['name'=>'Chung', 'label' => 'Cấu hình', 'link'=>'step-5', 'image'=>'config.png', 'i'=>0, 'role'=>'system-config']) -->
</div>
@endsection