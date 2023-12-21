@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-default">
            <div class="card-header">Đổi mật khẩu</div>

            <div class="card-body">
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <form class="form-horizontal" method="POST" action="{{ route('changePassword') }}">
                    {{ csrf_field() }}

                    <div class="row form-group">
                        <!-- <label for="new-password" class="col-md-4 control-label">Mật khẩu hiện tại</label> -->
                        <label for="current-password" class="col-md-4 col-form-label text-md-right">{{ __('Mật khẩu hiện tại') }}</label>
                        <div class="col-md-6">
                            <input id="current-password" type="password" class="form-control{{ $errors->has('current-password') ? ' is-invalid' : '' }}" name="current-password" required>
                            @if ($errors->has('current-password'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('current-password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="row form-group">
                        <!-- <label for="new-password" class="col-md-4 control-label">Mật khẩu mới</label> -->
                        <label for="new-password" class="col-md-4 col-form-label text-md-right">{{ __('Mật khẩu mới') }}</label>
                        
                        <div class="col-md-6">
                            <input id="new-password" type="password" class="form-control {{ $errors->has('new-password') ? ' is-invalid' : '' }}" name="new-password" required>

                            @if ($errors->has('new-password'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('new-password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="row form-group">
                        <!-- <label for="new-password-confirm" class="col-md-4 control-label">Nhập lại mật khẩu mới</label> -->
                        <label for="new-password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Mật khẩu mới') }}</label>
                        
                        <div class="col-md-6">
                            <input id="new-password-confirm" type="password" class="form-control {{ $errors->has('new-password-confirmation') ? ' is-invalid' : '' }}" name="new-password-confirmation" required>
                            @if ($errors->has('new-password-confirmation'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('new-password-confirmation') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-md-12 text-align-center">
                            <button type="submit" class="btn btn-success">
                                Đổi mật khẩu
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection