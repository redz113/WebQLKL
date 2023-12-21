<div class="col-xs-12 col-sm-12 col-md-7">
    <div class="form-group required">
        <strong>Họ và tên:</strong>
        {!! Form::text('name', null, array('placeholder' => 'Nhập tên đơn vị','class' => 'form-control')) !!}
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-7">
    <div class="form-group required">
        <strong>Tên đăng nhập:</strong>
        {!! Form::text('username', null, array( 'id'=>'username', 'placeholder' => 'Nhập tên đăng nhập: chỉ bao gồm kí tự, số, gạch ngang(-), gạch dưới(_)','class' => 'form-control')) !!}
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-7">
    <div class="form-group">
        <strong>Email:</strong>
        {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-7">
    <div class="form-group">
        <strong>Mật khẩu:</strong>
        {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-7">
    <div class="form-group">
        <strong>Nhập lại mật khẩu:</strong>
        {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control'))
        !!}
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-7">
    <div class="form-group">
        <strong>Quyền:</strong>
        {!! Form::select('roles[]', $roles, $user->role??null, array('placeholder' => 'Chọn quyền', 'class' => 'form-control')) !!}
    </div>
</div>
<script>
    $("#username").on("input", function() {
        $("#username").val(removeUnicode($(this).val()));
    });
</script>