<div class="mb-2">
    <div class="float-left">
        @can('topic-report')
        <a class="btn btn-warning" href="{{ route('instructor-topics-list-export', ['id' => $user]) }}"> Xuất báo cáo</a>
        @endcan
    </div>
    <div class="float-right">
    </div>
</div>

<div class="table-responsive">
<table class="table table-bordered table-hover">
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
            <td class="align-middle">{{ $topic->name }}</td>
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
</div>
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title w-100" id="myModalLabel">XÓA ĐỀ TÀI</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id='contentRS'></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Hủy</button>
                @can('topic-delete')
                {!! Form::open(['method' => 'DELETE','route' => ['topics.destroy', $topic->id??0],'style'=>'display:inline', 'id'=>'deleteRS'])!!}
                {!! Form::submit('Xóa', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}
                @endcan
            </div>
        </div>
    </div>
</div>
{!! $topics->links() !!}

<script>
    $(document).ready(function() {
        $('#delete').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('rsid')
            $('#deleteRS').attr('action', document.location.origin + '/researchs/' + id)
            $('#contentRS').text('Bạn có chắc muốn xóa đề tài ' + id + ' không?')
        })
    })
</script>