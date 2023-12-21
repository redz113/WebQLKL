@extends('layouts.app')


@section('content')
<div class="card">
    <div class="card-header boder-0">
        <div class="row">
            <div class="col-4 text-left">
                <h2>Quản lý quyền</h2>
            </div>
            <div class="col text-right">
                @can('role-create')
                <a class="btn btn-success" href="{{ route('roles.create') }}">Tạo</a>
                @endcan
            
                <a class="btn btn-primary" href="{{ url('/') }}">Quay lại</a>
            </div>
        </div>
    </div>
</div>


@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif

<div class="card-body boder-0">
    <div class="table-responsive">
        <table class="table table-hover">
            <tr class="badge-default">
                <th>STT</th>
                <th>Quyền</th>
                <th class="w-25">Thao tác</th>
            </tr>
            @foreach ($roles as $key => $role)
            <tr>
                <td class="align-middle">{{ ++$i }}</td>
                <td class="align-middle">{{ $role->name }}</td>
                <td class="align-middle text-right">
                    <a class="btn btn-info mx-0 mb-1 m-sm-1" href="{{ route('roles.show',$role->id) }}">Xem</a>
                    @can('role-edit')
                    <a class="btn btn-primary mx-0 mb-1 m-sm-1" href="{{ route('roles.edit',$role->id) }}">Sửa</a>
                    @endcan
                    
                    @if($role->id != Auth::user()->role)
                    @can('role-delete')
                    {!! Form::open(['method' => 'DELETE',
                                    'route' => ['roles.destroy', $role->id],
                                    'style'=>'display:inline',
                                    'onsubmit' => "return confirmDelete('Bạn có chắc muốn xóa quyền \'$role->name\' không?')",])
                    !!}
                    {!! Form::submit('Xóa', ['class' => 'btn btn-danger mx-0 mb-1 m-sm-1']) !!}
                    {!! Form::close() !!}
                    @endcan
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    
    {!! $roles->render() !!}
</div>


@endsection