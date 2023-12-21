@extends('layouts.app')


@section('content')
<div class="card">
    <div class="card-header boder-0">
        <div class="float-left">
            <h2>Sửa thông tin đề tài</h2>
        </div>
        <div class="float-right">
            <a class="btn btn-primary" href="{{ url('instructor-topics-list') }}">Quay lại</a>
        </div>
    </div>
</div>


@if (count($errors) > 0)
<div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


{!! Form::model($topic, ['method' => 'PATCH','route' => ['topics.update', $topic]]) !!}
<div class="row justify-content-center">
    @include('topics.instructor.edit_form')
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-success">Lưu thay đổi</button>
    </div>
</div>
{!! Form::close() !!}

@endsection
