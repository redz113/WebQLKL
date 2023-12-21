@extends('layouts.app')


@section('content')
<div class="card">
    <div class="card-header boder-0">
        <div class="float-left">
            <h2>Tạo quyền mới</h2>
        </div>
        <div class="float-right">
            <a class="btn btn-primary" href="{{ route('roles.index') }}">Quay lại</a>
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


{!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
<div class="container-fluid">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {!! Form::text('name', null, array('placeholder' => 'Tên quyền hạn: Quản trị viên, Chuyên viên Bộ,...','class'=> 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Permission:</strong>
            <div class='row'>
                @foreach($permission as $value)
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                        {{ $value->name }}</label>
                </div>
                @endforeach
                <div class='row'>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>

        {!! Form::close() !!}



        @endsection