@extends('layouts.app')

@section('content')

@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif

<div class="card">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0">Đăng ký đề tài khóa luận tốt nghiệp</h3>
            </div>
             <div class="col text-right">
                <a href="{{ url('/') }}" class="btn btn-primary">Quay lại</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">            
            <div class="col-lg-12">
                <p>
                    <span class="blockquote" style="color: red;">
                    <b>Chú ý:</b> Chưa đến thời gian đăng kí khóa luận tốt nghiệp. Xin vui lòng quay lại sau!
                    </span>
                </p>
            </div>
        </div>
        <div class="row">            
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <tr class="badge-default">
                        <th class="text-align-center">STT</th>
                        <th style="width: 30%;" class="text-align-center">Tên đề tài</th>
                        <th style="width: 30%;" class="text-align-center">Yêu cầu</th>
                        <th class="text-align-center">Bộ môn</th>
                        <th class="text-align-center">Giảng viên hướng dẫn</th>
                        <th class="text-align-center">Trạng thái</th>
                    </tr>
                    
                    @foreach ($topics as $key => $topic)
                    <tr>
                        <td class="text-align-center">{{ ++$i }}</td>
                        @if($topic->status == '1')
                            <td class="align-middle">
                                <a class="text-primary" rel="noopener noreferrer">{{ $topic->name }}</a>
                                <br><a> {{ $topic->description }} </a>
                            </td>
                        @else
                            <td class="align-middle">
                                <a class="text-danger" rel="noopener noreferrer">{{ $topic->name }}</a>
                                <br><a> {{ $topic->description }} </a>
                            </td>   
                        @endif 
                        <td class="text-align-center">{{ $topic->required }}</td>
                        <td class="text-align-center">{{ $topic->department }}</td>
                        <td class="text-align-center">{{ $topic->instructor_name }}</td>
                        <td class="text-align-center">
                            @if($topic->status == '1')
                            <div class="badge badge-success">Có thể đăng ký</div>   
                            @else
                            <div class="badge badge-danger">Đã đủ SV</div>   
                            @endif             
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
{{ $topics->links() }}
@endsection