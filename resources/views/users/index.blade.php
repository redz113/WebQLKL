@extends('layouts.app')


@section('content')

@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif

<div class="card">
    <div class="card-header boder-0">
        <div class="row">
            <div class="col-4">
                <h2>Quản lý tài khoản</h2>
            </div>
            <div class="col text-right">
                @can('topic-create')
                    <a class="btn btn-success" href="{{ route('users.create') }}">Tạo</a>
                @endcan
                <a class="btn btn-primary" href="{{ route('home') }}">Quay lại</a>
            </div>
        </div>
    </div>

    {{-- START FILTER --}}
    <div class="container-fluid my-0 py-0">
        <form action="" method="get" class="d-flex mb-0 justify-content-center">
            <div class="mr-1">
                <select name="role" class="form-control badge text-primary border-0">
                    <option value="">Vai trò</option>
                    @foreach ($roles as $key => $val)
                        <option value="{{ $key }}" {{ request()->role == $key ? 'selected' : "" }}>{{ $val }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mr-1 w-50">
                <input type="text" name="keyword" value="{{ request()->keyword }}" placeholder="Nhập từ khóa ..." class="form-control text-primary">
            </div>
            <button class="btn  btn-dark" id="btn-click"><i class="fas fa-search"></i></button>
        </form>
    </div>

    <div class="card-body table-responsive">
        <div class="mb-2">
            <div class="float-left">
                        <a class="btn btn-success" href="{{ route('import') }}"> Thêm tài khoản</a>
                    </div>
            <div class="float-right">
            </div>
        </div>
        <table class="table table-bordered table-hover">
            <tr class="badge-default">
                <th>STT</th>
                <th>Họ và tên</th>
                <th>Tên đăng nhập</th>
                <th>Vai trò</th>
                <th>SL đề tài</th>
                <th width="270px">Thao tác</th>
            </tr>
            
            @foreach ($users as $key => $user)
            <tr>
                <td class="align-middle">{{ ++$i }}</td>
                <td class="align-middle">{{ $user->name }}</td>
                <td class="align-middle">{{ $user->username }}</td>
                <td class="align-middle">
                    @if(!empty($user->getRoleNames()))
                    @foreach($user->getRoleNames() as $v)
                    <div class="badge badge-success">{{ $v }}</div>
                    @endforeach
                    @endif
                </td>
                <td class="text-center align-middle">{{$user->topics_count}}</td>
                <td class="align-middle text-right">
                    <a class="btn btn-info mr-0 mb-2" href="{{ route('users.show', $user) }}">Xem</a>
                    @can('user-edit')
                    <a class="btn btn-primary mr-0 mb-2" href="{{ route('users.edit', $user->id) }}">Sửa</a>
                    @endcan

                    @can('user-delete')
                    {!! Form::open(['method' => 'DELETE',
                                    'route' => ['users.destroy', $user->id],
                                    'style'=>'display:inline', 
                                    'onsubmit' => "return confirmDelete('Bạn có chắc muốn tài khoản có tên \'$user->name\' không?')", 
                                   ])!!}
                    {!! Form::submit('Xóa', ['class' => 'btn btn-danger confirm mr-0 mb-2']) !!}
                    {!! Form::close() !!}
                    @endcan
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

<div class="table-responsive">
    {!! $users->render() !!}
</div>
@endsection




