 @extends('layouts.app')


@section('content')
<div class="card" id="topics-list">
    <div class="card-header border-0">
        <div class="row">
            <div class="col-4">
                <h2>Quản lý đề tài</h2>
            </div>
            <div class="col text-right">
            @can('topic-create')
                <a class="btn btn-success" href="{{ route('topics.create') }}">Tạo</a>
            @endcan
                <a class="btn btn-primary" href="{{ url('/') }}">Quay lại</a>
            </div>
        </div>
    </div>

    @if(Session::has('Success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('Success') }}
        </div>
    @endif

    {{-- START FILTER --}}
    <div class="container-fluid my-0 py-0">
        <form action="" method="get" class="d-flex flex-nowrap mb-0 justify-content-center mr-4">
            <div class="mr-1 ">
                <select name="department" class="form-control badge text-primary border-0">
                    <option value="">Bộ Môn</option>
                    @foreach ($departmentArr as $val)
                        <option value="{{ $val }}" {{ request()->department == $val ? 'selected' : "" }}>{{ $val }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mr-1 ">
                <select name="academic_year" class="form-control badge text-primary  border-0">
                    <option value="">Niên khóa</option>
                    @foreach ($academic_year_arr as $key => $val)
                        <option value="{{ $key }}" {{ request()->academic_year == $key ? 'selected' : "" }}>{{ $val }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mr-1 ">
                <select name="status" class="form-control badge text-primary border-0">
                    <option value="">Trạng thái</option>
                    <option value="0" {{ request()->status === "0" ? 'selected' : "" }}>Đã đủ SV</option>
                    <option value="1" {{ request()->status === "1" ? 'selected' : "" }}>Có thể đăng ký</option>
                </select>
            </div>
            
            <div class="mr-1 flex-grow-1">
                <input type="text" name="keyword" value="{{ request()->keyword }}" placeholder="Nhập từ khóa ..." class="form-control text-primary">
            </div>

            <button class="btn  btn-dark" id="btn-click"><i class="fas fa-search"></i></button>
        </form>
    </div>

    <div class="card-body pt-1">
        <table class="table table-hover table-responsive-md w-100">
            <tr class="badge-default">
                <th>STT</th>
                <th>Tên đề tài</th>
                <th>Bộ môn</th>
                <th>Số lượng SV</th>
                <th>Ghi chú</th>
                <th>GVHD</th>
                <th>Niên Khóa</th>
                <th>Trạng thái</th>
                <th width="270px">Thao tác</th>
            </tr>
            
            @foreach ($topics as $key => $topic)
            <tr>
                <td class="align-middle">{{ ++$i }}</td> 
                <td class="align-middle">{{ $topic->name }}</td>
                <td class="align-middle">{{ $topic->department }}</td>
                <td class="align-middle">{{ $topic->number_student }}</td>
                <td class="align-middle">{{ $topic->note }}</td>
                <td class="align-middle">{{ $topic->instructor_name }}</td>
                <td class="align-middle">{{ $topic->academic_year }}</td>
                <td class="align-middle">
                    @if($topic->status == '0')                
                        <div class="badge badge-danger">Đã đủ SV</div>                
                    @else
                        <div class="badge badge-success">Có thể đăng ký</div>                
                    @endif
                </td>

                <td class="align-middle text-right">
                    <a href="{{ route('topics.show', $topic->id) }}" class="btn btn-info mx-0 mb-1 mr-sm-1">Xem</a>
                    @can('topic-edit')
                        <a href="{{ route('topics.edit', $topic->id ) }}" class="btn btn-primary mx-0 mb-1 mr-sm-1">Sửa</a>
                    @endcan
                   
                   @can('topic-delete')
                    {!! Form::open(
                        ['method' => 'DELETE', 
                        'route' => ['topics.destroy', $topic->id], 
                        'onsubmit' => "return confirmDelete('Bạn có chắc muốn xóa đề tài \'$topic->name\' của giảng viên \'$topic->instructor_name\' không?')",
                        'style' => 'display:inline']) !!}
                    {!! Form::submit('Xóa', ['class' => 'btn btn-danger confirm mx-0 mb-1 mr-sm-1']) !!}
                    {!! Form::close() !!}
                    @endcan
                </td>
                
            </tr>
            @endforeach
        </table>
    </div>
</div>


@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif

<div class="table-responsive">
{!! $topics->appends($param)->render() !!}
</div>

@endsection
