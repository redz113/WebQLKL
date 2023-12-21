@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0">Đăng ký đề tài khóa luận tốt nghiệp</h3>
            </div>
            <div class="col text-right">
                <a href="{{ url('/') }}" class="btn btn-primary">Trang chủ</a>
            </div>
        </div>
    </div>

    
    <div class="card-body">
        <div class="row mb-1">
            <div class="float-left">
                @can('topic-report')
                <a class="btn btn-warning" href="{{ route('topics-register-result-export', request()->page) }}"> Xuất báo cáo</a>
                @endcan
            </div>
            <div class="float-right">
            </div>
        </div>
        <div class="row">            
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <tr class="badge-default">
                        <th class="text-align-center">STT</th>
                        <th class="text-align-center">Tên đề tài</th>
                        <th class="text-align-center">Bộ môn</th>
                        <th class="text-align-center">Mã sinh viên</th>
                        <th class="text-align-center">Họ tên sv</th>
                        <th class="text-align-center">Giảng viên hướng dẫn </th>
                    </tr>
                    
                    @foreach ($register_result as $key => $result)
                    <tr>
                        <td class="text-align-center">{{ ++$i }}</td>
                        <td style="width: 40%;" class="align-middle">{{ $result->topic_name }}</td>  
                        <td class="text-align-center">{{ $result->department }}</td>
                        <td class="text-align-center">{{ $result->student_id }}</td>
                        <td class="text-align-center">{{ $result->student_name }}</td>
                        <td class="text-align-center">{{ $result->instructor_name }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

{!! $register_result->render() !!}
@endsection