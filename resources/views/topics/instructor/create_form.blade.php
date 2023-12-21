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
                {!! Form::select('department', $departmentArr, null, array('placeholder' => 'Chọn bộ môn', 'class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <strong>Niên khóa</strong>
                {!! Form::text('academic_year', $nien_khoa, array('placeholder' => 'Chọn bộ môn', 'class' => 'form-control', 'disabled' => 'disabled')) !!}
            </div>
        </div>
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-7">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group required">
                <strong>Số lượng SV:</strong>
                {!! Form::number('number_student', 1, array('class' => 'form-control', 'min' => 1)) !!}
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


