@extends('layouts.app')


@section('content')
<div class="card">
    <div class="card-header boder-0">
        <div class="float-left dp-flex">
            <h3>GVHD: 
                {{$user->name}}
                @if(!empty($user->getRoleNames()))
                @foreach($user->getRoleNames() as $v)
                <label class="badge badge-success">{{ $v }}</label>
                @endforeach
                @endif
            </h3>
        </div>
        <div class="float-right">
            <!-- <a class="btn btn-primary" href="{{ route('users.show', $user->id) }}"> Quay lại </a> -->
            <a class="btn btn-primary" href="{{ URL::previous() }}">Quay lại</a>
        </div>
    </div>

    <div class="card-body boder-0">
        <div class="row">
            <div class="col-sm-12 col-lg-12 margin-tb">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                                <label for="my-input">Tên đề tài</label>
                                <input id="my-input" class="form-control" type="text" name="" value="{{$topic->name}}" disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3 col-md-2">
                        <div class="form-group">
                                <label for="my-input">Số lượng SV</label>
                                <input id="my-input" class="form-control" type="text" name="" value="{{$topic->number_student}}" disabled>
                        </div>
                    </div>
                    <div class="col-sm-9 col-ms-8">
                        <div class="form-group">
                                <label for="my-input">Ghi chú</label>
                                <input id="my-input" class="form-control" type="text" name="" value="{{$topic->note}}" disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                                <label for="my-input">Bộ môn</label>
                                <input id="my-input" class="form-control" type="text" name="" value="{{$topic->department}}" disabled>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-2">
                        <div class="form-group">
                            <label for="my-input">Niên khóa</label>
                            <input id="my-input" class="form-control" type="text" name="" value="{{$topic->academic_year}}"
                                disabled>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                                <label for="my-input">Trạng thái</label>
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
                        <label for="my-input">Yêu cầu</label>
                        <textarea style="width: 100%;" name="" id="" cols="30" rows="10"  disabled>{{$topic->required}}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('topics.list_students_register_topic')

@endsection