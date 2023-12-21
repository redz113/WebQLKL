@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header boder-0">
                <div class="float-left">
                    <h3>Thêm đề tài</h3>
                </div>
                <div class="float-right">
                    <a href="{{ route('topics.index') }}" class="btn btn-primary">Danh sách đề tài</a>
                </div>
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
    {!! Form::open(array('route' => 'topics.store','method'=>'POST')) !!}
    <div class="row justify-content-center">
        @include('topics.create-form')
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Tạo mới</button>
        </div>
    </div>
    {!! Form::close() !!}

@endsection
