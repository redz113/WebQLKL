@extends('layouts.app')


@section('content')
<div class="card">
    <div class="card-header boder-0">
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
        <div class="float-right">
            <a class="btn btn-primary" href="{{ route('users.index') }}">Quay lại</a>
        </div>
    </div>
</div>

@include('users.topics_list', ['user' => $user])

@endsection