@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header border-0">
            <div class="row">
                <div class="col-4 text-left">
                    <h2>Cấu hình hệ thống</h2>
                </div>
                <div class="col text-right">
                    <a href="{{ route("configurations.edit") }}" class="btn btn-success">Cập nhập</a>
                    <a href="{{ route("home") }}" class="btn btn-primary">Quay lại</a>
    
                </div>
            </div>
        </div>


        <div class="card-body border-0">
            <div class="">
                    <div class="mb-2">
                        <h3 class="py-0 my-1 d-inline">Niên khóa:</h3>
                        <select name="academic_year" class="ml-5 px-2 py-1" disabled>
                            <option value="{{ $nien_khoa }}">{{ $nien_khoa }}</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-md-4 mb-2">
                            <h3 class="py-0 my-1">Ngày mở cổng đăng ký:</h3>
                            <input name="start_date" disabled 
                                    type="datetime-local" 
                                    value="{{ $start_date }}" 
                                    class="ml-5 px-2 py-1">
                        </div>
    
                        <div class="col-sm-6 col-md-4 mb-2">
                            <h3 class="py-0 my-1">Ngày đóng cổng đăng ký:</h3>
                            <input name="end_date" disabled
                                    type="datetime-local"
                                    value="{{ $end_date }}"
                                    min="{{ $start_date }}" 
                                    class="ml-5 px-2 py-1">
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection