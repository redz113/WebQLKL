@extends('layouts.app')

@section('content')


<div class="card">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0">{{ __('ĐĂNG KÝ KHÓA LUẬN TỐT NGHỆP CHO SINH VIÊN KHOA CNTT!') }}</h3>
            </div>
            <!-- <div class="col text-right">
                <a href="#!" class="btn btn-sm btn-primary">See all</a>
            </div> -->
        </div>
        <div class="row">
            <div class="col-lg-12 col-12">
                <p class="text-danger">
                    
                </p>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">            
            
            @can('topic-register')
            <div class="col-xl-4 col-md-6">
                <a href=" {{ url('topics-register-list/all') }} ">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body box">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-primary mb-0">Đăng ký</h5>
                                    <span class="h2 font-weight-bold mb-0">Đăng ký đề tài</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                        <i class="ni ni-hat-3"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- <p class="mt-3 mb-0 text-sm">
                                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                                <span class="text-nowrap">Since last month</span>
                            </p> -->
                        </div>
                    </div>
                </a>
            </div>
            @else
            <div class="col-xl-4 col-md-6 disabled">
                <div class="card card-stats">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-primary mb-0">Đăng ký</h5>
                                <span class="h2 font-weight-bold mb-0">Đăng ký đề tài</span>
                            </div>
                            <div class="col-auto">
                                <div
                                    class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                    <i class="ni ni-active-40"></i>
                                </div>
                            </div>
                        </div>
                        <!-- <p class="mt-3 mb-0 text-sm">
                            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                            <span class="text-nowrap">Since last month</span>
                        </p> -->
                    </div>
                </div>
            </div>
            @endcan

            @can('topic-list')
            <div class="col-xl-4 col-md-6">
                <a href="topics">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body box">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-primary mb-0">Quản lý</h5>
                                    <span class="h2 font-weight-bold mb-0">Quản lý đề tài</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                        <i class="ni ni-books"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- <p class="mt-3 mb-0 text-sm">
                                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                                <span class="text-nowrap">Since last month</span>
                            </p> -->
                        </div>
                    </div>
                </a>
            </div>
            @else
            <div class="col-xl-4 col-md-6 disabled">
                <div class="card card-stats">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-primary mb-0">Quản lý</h5>
                                <span class="h2 font-weight-bold mb-0">Quản lý đề tài</span>
                            </div>
                            <div class="col-auto">
                                <div
                                    class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                    <i class="ni ni-books"></i>
                                </div>
                            </div>
                        </div>
                        <!-- <p class="mt-3 mb-0 text-sm">
                            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                            <span class="text-nowrap">Since last month</span>
                        </p> -->
                    </div>
                </div>
            </div>
            @endcan

            @can('user-list')
            <div class="col-xl-4 col-md-6">
                <a href="users">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body box">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-primary mb-0">Quản lý</h5>
                                    <span class="h2 font-weight-bold mb-0">Quản lý tài khoản</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                        <i class="ni ni-circle-08"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- <p class="mt-3 mb-0 text-sm">
                                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                                <span class="text-nowrap">Since last month</span>
                            </p> -->
                        </div>
                    </div>
                </a>
            </div>
            @else
            <div class="col-xl-4 col-md-6 disabled">
                <div class="card card-stats">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-primary mb-0">Quản lý</h5>
                                <span class="h2 font-weight-bold mb-0">Quản lý tài khoản</span>
                            </div>
                            <div class="col-auto">
                                <div
                                    class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                    <i class="ni ni-circle-08"></i>
                                </div>
                            </div>
                        </div>
                        <!-- <p class="mt-3 mb-0 text-sm">
                            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                            <span class="text-nowrap">Since last month</span>
                        </p> -->
                    </div>
                </div>
            </div>
            @endcan

            @can('instructor-topic-list')
            <div class="col-xl-4 col-md-6">
                <a href="instructor-topics-list">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body box">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Quản lý</h5>
                                    <span class="h2 font-weight-bold mb-0">Đề tài của giảng viên</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                        <i class="ni ni-books"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- <p class="mt-3 mb-0 text-sm">
                                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                                <span class="text-nowrap">Since last month</span>
                            </p> -->
                        </div>
                    </div>
                </a>
            </div>
            @else
            <div class="col-xl-4 col-md-6 disabled">
                <div class="card card-stats">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Quản lý</h5>
                                <span class="h2 font-weight-bold mb-0">Đề tài của giảng viên</span>
                            </div>
                            <div class="col-auto">
                                <div
                                    class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                    <i class="ni ni-books"></i>
                                </div>
                            </div>
                        </div>
                        <!-- <p class="mt-3 mb-0 text-sm">
                            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                            <span class="text-nowrap">Since last month</span>
                        </p> -->
                    </div>
                </div>
            </div>
            @endcan

        </div>
    </div>
</div>
@endsection