@extends('layouts.app')

@section('content')

@php
   
@endphp

@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif

@if (!$checkRegister)
    <div class="text-center">
        <span style="white-space: normal;" class="badge badge-danger h1">
            Tài khoản không đủ điều kiện để đăng ký khóa luận. <br>Liên hệ giáo vụ khoa để được xử lý.
        </span>
    </div>
@endif
<div class="card" id="topics-register-list">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0">Đăng ký đề tài khóa luận tốt nghiệp</h3>
            </div>

            <div class="col text-right">
                <a class="btn btn-primary" href="{{ url('/') }}"> Quay lại </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">            
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <tr class="badge-default">
                        <th class="text-align-center">STT</th>
                        <th style="width: 30%;" class="text-align-center">
                            <a class="thead" href=" {{ url('topics-register-list', ['sort' => $sort_param['topics_name']]) }} ">    
                                <div class="col-xl-12">
                                    Tên đề tài  <i class="fas fa-arrows-alt-v"></i>
                                </div>
                            </a>
                        </th>
                        <th style="width: 30%;" class="text-align-center">Yêu cầu</th>
                        <th class="text-align-center">
                            <a class="thead" href=" {{ url('topics-register-list', ['sort' => $sort_param['topics_department']]) }} ">    
                                <div class="col-xl-12">
                                    Bộ môn  <i class="fas fa-arrows-alt-v"></i>
                                </div>
                            </a>
                        </th>
                        <th class="text-align-center">
                            <a class="thead" href=" {{ url('topics-register-list', ['sort' => $sort_param['users_name']]) }} ">    
                                <div class="col-xl-12">
                                    Giảng viên hướng dẫn  <i class="fas fa-arrows-alt-v"></i>
                                </div>
                            </a>
                        </th>
                        <th class="text-align-center">
                            <a class="thead" href=" {{ url('topics-register-list', ['sort' => $sort_param['topics_status']]) }} ">    
                                <div class="col-xl-12">
                                    Trạng thái  <i class="fas fa-arrows-alt-v"></i>
                                </div>
                            </a>
                        </th>
                        <th class="text-align-center">Xem chi tiết</th>
                    </tr>

                    @foreach ($topics as $key => $topic)
                    <tr>
                        <td class="text-align-center">{{ ++$i }}</td>
                        @if($topic->status == '1' && $checkRegister)
                            <td class="align-middle">
                                <a href="{{ route('topic-register-confirm', ['topic_id' => $topic->id]) }}" rel="noopener noreferrer">{{ $topic->name }}</a>
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
                        
                        <td class="text-align-center" style="text-align: center;">
                            @if($topic->status == '1' && $checkRegister)
                                @can('topic-register')
                                    <a href="{{ route('topic-register-confirm', ['topic_id' => $topic->id]) }}" class="btn btn-primary" type="submit"><i class="far fa-edit"></i></a>
                                @endcan  
                            @else
                                <input type="hidden" name="topic_id" value="{{$topic->id}}">
                                <button class="btn btn-primary" disabled><i class="far fa-edit"></i></button>
                            @endif
                            
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

{!! $topics->render() !!}
@endsection