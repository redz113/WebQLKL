@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Cuộc thi khoa học kỹ thuật toàn quốc') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Chào mừng các bạn đã đến với cuộc thi khoa học kỹ thuật toàn quốc 2021!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
