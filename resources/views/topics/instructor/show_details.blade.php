@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0">Đề tài của giảng viên</h3>
            </div>
            <div class="col text-right">
            <a class="btn btn-primary" href="{{ url('instructor-topics-list') }}"> Quay lại</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="float-left dp-flex">
                    <h3>Giảng viên hướng dẫn:
                        <label class="badge badge-success">{{ $user->name }}</label>
                    </h3>
                </div>
                <div class="float-right">
                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-lg-12 margin-tb">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="my-input">Tên đề tài</label>
                            <input class="form-control" name="" value="{{$topic->name}}"
                                disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 col-md-2">
                        <div class="form-group">
                            <label for="my-input">Số lượng SV</label>
                            <input id="my-input" class="form-control" type="text" name=""
                                value="{{$topic->number_student}}" disabled>
                        </div>
                    </div>

                    <div class="col-sm-9 col-md-8">
                        <div class="form-group">
                            <label for="">Ghi chú</label>
                            <input type="text" name="" id="" class="form-control" value="{{ $topic->note }}" disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="my-input">Bộ môn</label>
                            <input id="my-input" class="form-control" type="text" name="" value="{{$topic->department}}"
                                disabled>
                        </div>
                    </div>

                    <div class="col-sm-3 col-md-2">
                        <div class="form-group">
                            <label for="my-input">Niên khóa</label>
                            <input id="my-input" class="form-control" type="text" name="" value="{{$topic->academic_year}}"
                                disabled>
                        </div>
                    </div>

                    <div class="col-sm-3 col-md-2">
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
                        <textarea style="width: 100%;" name="" id="" cols="30" rows="10"
                            disabled>{{$topic->required}}</textarea>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <h3 class="mb-0"></h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <h3 class="mb-0">Sinh viên tham gia đề tài:</h3>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <tr class="badge-default">
                                <th class="text-align-center">STT</th>
                                <th class="text-align-center">
                                    Mã sinh viên
                                </th>
                                <th class="text-align-center">
                                    Họ và tên
                                </th>
                                <th class="text-align-center">
                                    Niên khóa
                                </th>
                                <th class="text-align-center">
                                    Email
                                </th>
                                <th class="text-align-center">
                                    Số điện thoại
                                </th>
                            </tr>
                            
                            @foreach ($students as $key => $student)
                            <tr>
                                <td class="text-align-center">{{ ++$i }}</td>
                                <td class="text-align-center">{{ $student->username }}</td>
                                <td class="text-align-center">{{ $student->name }}</td>
                                <td class="text-align-center">{{ $student->academic_year }}</td>
                                <td class="text-align-center">{{ $student->email }}</td>
                                <td class="text-align-center">{{ $student->phone }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</div>


@endsection