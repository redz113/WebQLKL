@extends('layouts.app')


@section('content')
<div class="card">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col-4">
                <h3 class="mb-0">Đề tài của giảng viên</h3>
            </div>
            <div class="col text-right">
                @can('topic-create')
                    <a class="btn btn-success mt-2" href="{{ route('instructor-topics-create') }}"> Tạo</a>
                @endcan
                <a class="btn btn-primary mt-2" href="{{ url('/') }}">Quay lại</a>
            </div>
        </div>
    </div>
    <div class="card-body">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="float-left dp-flex">
                        <h3>
                            {{$user->name}}
                            @if(!empty($user->getRoleNames()))
                            @foreach($user->getRoleNames() as $v)
                            <label class="badge badge-success">{{ $v }}</label>
                            @endforeach
                            @endif
                        </h3>
                    </div>
                </div>
            </div>

            @include('topics.instructor.list', ['user' => $user])
    </div>
</div>



@endsection