@extends('layouts.app')

<?php
    use Carbon\Carbon;
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $topic_register_time = DB::table('configurations')->first();
    $start = $topic_register_time->reg_open_date;
    $end = $topic_register_time->reg_close_date;
    $end_time = strtotime($end);
    $start_date = new DateTime($start);//start time
    $end_date = new DateTime($end);//end time
    $current_date_time = Carbon::now();
    
?>

@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif

@section('content')
<div class="card">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0">Đăng ký đề tài khóa luận tốt nghiệp</h3>
            </div>
            <div class="float-right">
                <a class="btn btn-primary" href="{{ url('/') }}"> Quay lại</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="float-left">
                            <h2>Đề tài bạn đã đăng ký</h2>
                        </div>
                    </div>
                    
                </div>
                <div class="float-left dp-flex">
                    <h3>Giảng viên hướng dẫn:
                        <label class="badge badge-success">{{ $topic->instructor_name }}</label>
                    </h3>
                </div>
            </div>
            <!--<div class="float-right">
                    <a class="btn btn-primary" href="{{url('home')}}"> Về Trang chủ</a>
                </div>-->
        </div>
            
        <div class="row">
            <div class="col-sm-12 col-lg-12 margin-tb">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="text-primary" for="my-input">Tên đề tài</label>
                            <textarea style="width: 100%;" name="" id="" cols="30" rows="3"
                                disabled>{{$topic->name}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="text-primary" for="my-input">Mô tả</label>
                            <textarea style="width: 100%;" name="" id="" cols="30" rows="3"
                                disabled>{{$topic->description}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="text-primary" for="my-input">Số lượng SV</label>
                            <input id="my-input" class="form-control" type="text" name=""
                                value="{{$topic->number_student}}" disabled>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="text-primary" for="my-input">Ghi chú</label>
                            <input id="my-input" class="form-control" type="text" name="" value="{{$topic->note}}"
                                disabled>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="text-primary" for="my-input">Bộ môn</label>
                            <input id="my-input" class="form-control" type="text" name=""
                                value="{{$topic->department}}" disabled>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="text-primary" for="my-input">Trạng thái</label>
                            <div class="align-middle">
                                @if($topic->status == '0')
                                <div class="badge badge-danger">Đã đủ SV</div>
                                @else
                                <div class="badge badge-success">Có thể đăng ký</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <label class="text-primary" for="my-input">Yêu cầu</label>
                        <textarea style="width: 100%;" name="" id="" cols="30" rows="10"
                            disabled>{{$topic->required}}</textarea>
                    </div>
                </div>
                <div class="row" style="margin: 10px;">
                    <div class="col-sm-12" style="text-align: center;">
                        <p>
                            <span class="blockquote" style="color: red;">
                            <b>Chú ý:</b> Mỗi sinh viên chỉ được đăng kí <b>duy nhất 1 đề tài</b>. 
                            Sau khi đăng kí, sinh viên sẽ không được đăng kí đề tài khác. 
                            Nếu sinh viên <b>hủy đăng kí</b>, thì <b>sinh viên khác sẽ có thể đăng kí đề tài này</b>.
                            </span>
                        </p>
                        @can('topic-register')
                            @if($current_date_time < $end_date)
                            <form action="{{url('topic-register-cancel')}}" method="post"
                                onsubmit="return confirm('Bạn thực sự muốn hủy đăng ký đề tài: {{$topic->name}}. GVHD: {{$topic->instructor_name}}?');">
                                @csrf
                                <input class="btn btn-danger" type="submit" value="Hủy đăng ký">
                            </form>
                            @endif
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



    @endsection