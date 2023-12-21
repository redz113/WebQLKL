@php $arr = ['one', 'two', 'three']; @endphp

@can($role??'')
<div class="col-lg-4 col-md-4 col-sm-6 col-12 my-3">
    <a href="{{$link??'#'}}" class="inforide">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-4 col-4 ride{{$arr[$i??2]}}">
                <img src="{{asset($image??'edit.png')}}">
            </div>
            <div class="col-lg-9 col-md-8 col-sm-8 col-8 fontsty">
                <h4>{{$name??"A"}}</h4>
                <h2>{{$label??"B"}}</h2>
            </div>
        </div>
    </a>
</div>
@else
<div class="col-lg-4 col-md-4 col-sm-6 col-12 my-3">
    <div class="inforide disable">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-4 col-4 ride{{$arr[$i??2]}}">
                <img src="{{asset($image??'edit.png')}}">
            </div>
            <div class="col-lg-9 col-md-8 col-sm-8 col-8 fontsty">
                <h4>{{$name??"A"}}</h4>
                <h2>{{$label??"B"}}</h2>
            </div>
        </div>
    </div>
</div>
@endcan