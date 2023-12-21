@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header border-0">
            <div class="float-left">
                <h2>Cấu hình hệ thống</h2>
            </div>
            <div class="float-right">
                <a href="{{ route('configurations.index') }}" class="btn btn-primary">Quay lại</a>
            </div>
        </div>


        {{-- @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif --}}

        @isset($error)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                <li>{{ $error }}</li>
            </ul>
        </div>
        @endisset




        <div class="card-body border-0">
            <div class="">
                <form action="{{ route('configurations.add') }}" method="POST">
                    @method('PATCH')
                    @csrf
                    <div class="mb-2">
                        <h3 class="py-0 my-1 d-inline">Niên khóa:</h3>
                        <select name="academic_year" class="ml-5 px-2 py-1">
                            @foreach ($academic_year_arr as $nk)
                                <option value="{{$nk}}" {{ $nien_khoa == $nk ? 'selected' : '' }}>
                                    {{ $nk }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-md-4 mb-2">
                            <h3 class="py-0 my-1">Ngày mở cổng đăng ký:</h3>
                            <input name="start_date" type="datetime-local" value="{{ $start_date }}" class="ml-5 px-2 py-1">
                        </div>
    
                        <div class="col-sm-6 col-md-4 mb-2">
                            <h3 class="py-0 my-1">Ngày đóng cổng đăng ký:</h3>
                            <input name="end_date" 
                                    type="datetime-local"
                                    value="{{ $end_date }}"
                                    class="ml-5 px-2 py-1">
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <button class="btn btn-success">Lưu thay đổi</button>
                    </div>
                </form>                
            </div>
        </div>
    </div>
@endsection