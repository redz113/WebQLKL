@extends('layouts.app')


@section('content')
<div class="card">
    <div class="card-header boder-0">
        <div class="float-left">
            <h2> Show Role</h2>
        </div>
        <div class="float-right">
            <a class="btn btn-primary" href="{{ route('roles.index') }}">Quay lại</a>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {{ $role->name }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Permissions:</strong>
            @if(!empty($rolePermissions))
                @foreach($rolePermissions as $v)
                    <label class="label label-success">{{ $v->name }},</label>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection