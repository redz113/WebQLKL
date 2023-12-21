@extends('layouts.app')

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
            <div class="col text-right">
                    <a class="btn btn-primary" href="{{ URL::previous() }}"> Quay lại</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="float-left">
                            <h2>Thông tin đề tài</h2>
                        </div>
                    </div>
                </div>
                <div class="float-left dp-flex">
                    <h3>Giảng viên hướng dẫn:
                        <label class="badge badge-success">{{ $user->name }}</label>
                    </h3>
                </div>
            </div>
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
                            <input id="my-input" class="form-control" type="text" name="" value="{{$topic->department}}"
                                disabled>
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
                        @if($topic->status == '1')
                        @can('topic-register')
                        <form style="margin: 0;" action="{{url('topics-register')}}" method="post"
                            onsubmit="return confirm('Bạn thực sự muốn đăng ký đề tài: {{$topic->name}}. GVHD: {{$user->name}}?');">
                            @csrf
                            <input type="hidden" name="topic_id" value="{{$topic->id}}">
                            <!-- <button class="btn btn-primary" type="submit"><i class="fa fa-check-square-o"> </i></button> -->
                            <input class="btn btn-success" type="submit" value="Đăng ký đề tài này">
                        </form>
                        @endcan
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection