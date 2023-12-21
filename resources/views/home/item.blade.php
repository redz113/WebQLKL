@php $arr = ['one', 'two', 'three']; @endphp

@can($role??'')
<div class="col-xl-4 col-md-6">
    <a href="{{$link??'#'}}">
        <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">{{$name??"A"}}</h5>
                        <span class="h2 font-weight-bold mb-0">{{$label??"B"}}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                            <i class="ni ni-hat-3"></i>
                        </div>
                    </div>
                </div>
                <!-- <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                    <span class="text-nowrap">Since last month</span>
                </p> -->
            </div>
        </div>
    </a>
</div>
@else
<div class="col-xl-3 col-md-6">
    <div class="card card-stats">
        <!-- Card body -->
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h5 class="card-title text-uppercase text-muted mb-0">{{$name??"A"}}</h5>
                    <span class="h2 font-weight-bold mb-0">{{$label??"B"}}</span>
                </div>
                <div class="col-auto">
                    <div
                        class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                        <i class="ni ni-active-40"></i>
                    </div>
                </div>
            </div>
            <!-- <p class="mt-3 mb-0 text-sm">
                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                <span class="text-nowrap">Since last month</span>
            </p> -->
        </div>
    </div>
</div>
@endcan

