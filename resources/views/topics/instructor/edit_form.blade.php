<div class="col-xs-12 col-sm-12 col-md-7">
    <div class="form-group required">
        <strong>Mã đề tài:</strong>
        {!! Form::text('id', null, array('class' => 'form-control', 'readonly')) !!}
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-7">
    <div class="form-group required">
        <strong>Tên đề tài:</strong>
        {!! Form::text('name', null, array('placeholder' => 'Nhập tên đề tài','class' => 'form-control')) !!}
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-7">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group required">
                <strong>Bộ môn:</strong>
                {!! Form::select('department', $departmentArr, array_search($topic->department,$departmentArr), array('placeholder' => 'Chọn bộ môn', 'class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-sm-3 col-md-2">
            <div class="form-group">
                <strong>Niên khóa</strong>
                {!! Form::select('academic_year', $academic_year_arr, array_search($topic->academic_year,$academic_year_arr), array('class' => 'form-control')) !!}
            </div>
        </div>
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-7">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group required">
                <strong>Số lượng SV:</strong>
                {!! Form::number('number_student', null, array('class' => 'form-control', 'min' => 1)) !!}
            </div>
        </div>
        <div class="col-sm-8">
            <div class="form-group">
                <strong>Ghi chú:</strong>
                {!! Form::text('note', null, array('class' => 'form-control')) !!}
            </div>
        </div>
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-7">
    <div class="form-group">
        <strong>Yêu cầu:</strong>
        {!! Form::textarea('required', null, array('rows' => 10, 'cols' => 30, 'class' => 'form-control')) !!}
    </div>
</div>

<input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
<input type="hidden" name="routeRedirect" value="instructor-topics-list">
<input type="hidden" name="user_id" value="{{ $topic->user_id }}">



