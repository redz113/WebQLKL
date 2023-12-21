{{-- Message --}}
<div class="col-12">
    @if (isset($success))
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        {{ $success }}
    </div>
@endif

@if (isset($error))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        {{ $error }}
    </div>
@endif
</div>