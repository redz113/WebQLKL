<table class="table table-bordered table-hover">
    <tr>
        <td colspan="6">DANH SACH ĐỀ TÀI CỦA GIẢNG VIÊN</td>
    </tr>

    <tr>
        <th>Tên Giảng Viên:</th>
        <th colspan="5">{{ $instructorName }}</th>
    </tr>

    <tr>
        <td colspan="6"></td>
    </tr>
    
    <tr class="badge-default">
        <th class="text-align-center">STT</th>
        <th style="min-width: 200px;" class="text-align-center">Tên đề tài</th>
        <th class="text-align-center">Bộ môn</th>
        <th class="text-align-center">Số lượng SV</th>
        <th class="text-align-center">Ghi chú</th>
        <th class="text-align-center">Trạng thái</th>
    </tr>
    
    @foreach ($topics as $key => $topic)
    <tr>
        <td class="align-middle text-align-center">{{ ++$i }}</td>
        <td class="align-middle">
            {{ $topic->name }}
        </td>
        <td class="align-middle text-align-center">{{ $topic->department }}</td>
        <td class="align-middle text-align-center">{{ $topic->number_student }}</td>
        <td class="align-middle text-align-center">{{ $topic->note }}</td>
        <td class="align-middle text-align-center">
            @if($topic->status == '0')                
                <div class="badge badge-danger">Đã đủ SV</div>                
            @else
                <div class="badge badge-success">Có thể đăng ký</div>                
            @endif
        </td>
    </tr>
    @endforeach
</table>
