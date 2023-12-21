@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header boder-0">
            <div class="row">
                <div class="col-4">
                    <h2>Tạo tài khoản</h2>
                </div>
                <div class="col text-right">
                    <a class="btn btn-primary" href="{{route('users.index')}}">Quay lại</a>
                </div>
            </div>
        </div>
        <form method="POST" action="{{route('upload')}}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    
                    <div class="col-md-12 mb-3 mt-3">
                        <p>Vui lòng tải lên file với định dạng sau <a href="{{ asset('assets/files/import-users.xlsx') }}" target="_blank">Mẫu định dạng file Excel</a></p>
                    </div>

                    {{-- Alert Messages --}}
                    @include('common.alert')

                    {{-- File Input --}}
                    <div class="col-sm-12 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>File đầu vào(.xlsx)</label>
                        <input 
                            type="file" 
                            class="form-control form-control-user @error('file') is-invalid @enderror" 
                            id="exampleFile"
                            name="file" 
                            value="{{ old('file') }}">

                        @error('file')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                </div>
            </div>

            @if (isset($listUserImport))
                <div class="container">
                    <div class="card table-responsive">
                        <div class="card-header pb-0">
                            <div class="h1">Kết quả</div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr class="badge-dark">
                                    <th>Trạng thái</th>
                                    <th>Hàng</th>
                                    <th>Họ và tên</th>
                                    <th>Tên đăng nhập</th>
                                    <th>Email</th>
                                    <th>Mật khẩu</th>
                                    <th>Niên khóa</th>
                                    <th>Vai trò</th>
                                </tr>
                                
                                @php
                                    $countImportSuccess = 0
                                @endphp
                                @foreach ($listUserImport[0] as $item)
                                    <tr>
                                        <td class="">
                                            @php
                                                ++$row;
                                                $flag=1;
                                                foreach ($failures->all() as $error){
                                                    // $error->row();
                                                    if($error->row() == $row){
                                                        echo "<strong class='text-danger'>" .$error->errors()[0] . "</strong><br>";
                                                        $flag = 0;
                                                    }
                                                }
                                                if ($flag == 1) {
                                                    ++$countImportSuccess;
                                                    echo "<strong class='text-success'>Đã tải lên</strong>";
                                                }
                                            @endphp
                                        </td>
                                        <td class="text-center align-middle">{{ $row }}</td>
                                        <td class="text-center align-middle">{{ $item['ho_va_ten'] }}</td>
                                        <td class="text-center align-middle">{{ $item['ten_dang_nhap'] }}</td>
                                        <td class="text-center align-middle">{{ $item['email'] }}</td>
                                        <td class="text-center align-middle">{{ $item['mat_khau'] }}</td>
                                        <td class="text-center align-middle">{{ $item['nien_khoa'] }}</td>
                                        <td class="text-center align-middle">{{ $item['vai_tro'] }}</td>
                                    </tr>
                                @endforeach
                                <tr class="badge-dark">
                                    <th colspan="8" class="text-left text-white">Số tài khoản đã tải lên thành công: {{ $countImportSuccess }}</th>
                                </tr>
                            </table> 
                        </div>
                    </div>
                </div>
            @endif

            <div class="card-footer">
                <button type="submit" class="btn btn-success btn-user float-right mb-3">Tải Lên</button>
                <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('users.index') }}">Hủy</a>
            </div>
        </form>
    </div>

</div>


@endsection