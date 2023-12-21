<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <h3 class="mb-0"></h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <h3 class="mb-0">Sinh viên tham gia đề tài:</h3>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <tr class="badge-default">
                        <th class="text-align-center">STT</th>
                        <th class="text-align-center">
                            Mã sinh viên
                        </th>
                        <th class="text-align-center">
                            Họ và tên
                        </th>
                        <th class="text-align-center">
                            Niên khóa
                        </th>
                        <th class="text-align-center">
                            Email
                        </th>
                        <th class="text-align-center">
                            Số điện thoại
                        </th>
                    </tr>
                    
                    @foreach ($students as $key => $student)
                    <tr>
                        <td class="text-align-center">{{ ++$i }}</td>
                        <td class="text-align-center">{{ $student->username }}</td>
                        <td class="text-align-center">{{ $student->name }}</td>
                        <td class="text-align-center">{{ $student->academic_year }}</td>
                        <td class="text-align-center">{{ $student->email }}</td>
                        <td class="text-align-center">{{ $student->phone }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
       
    </div>
</div>