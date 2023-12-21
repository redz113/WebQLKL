<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Icons -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('fithnue.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Hệ thống đăng ký khóa luận tốt nghiệp - Khoa Công nghệ thông tin - Trường Đại học Sư phạm Hà Nội</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Page plugins -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}"
        type="text/css">
    <!-- Argon CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/argon.css?v=1.2.0') }}" type="text/css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>

<?php
use Carbon\Carbon;

$gvhd = DB::table('users')
->select(DB::raw('count(id) as number_gvhd'))
->where('role', 4)
->where('deleted_at', NULL)
->get();
$number_gvhd = $gvhd[0]->number_gvhd;

$configurations = DB::table('configurations')
                ->select('academic_year', 'reg_open_date', 'reg_close_date')
                ->first(); 

$khoa_hoc = $configurations->academic_year;

// session(['nien_khoa' => $khoa_hoc]);

$sv = DB::table('users')
->select(DB::raw('count(id) as number_sv'))
->where('role', 5)
->where('users.academic_year', '=', $khoa_hoc)
->where('deleted_at', NULL)
->get();
$number_sv = $sv[0]->number_sv;

$number_pgs = DB::table('users')
->select(DB::raw('count(id) as number_pgs'))
->where('role', 4)
->where('name', "LIKE" , '%pgs.%')
->where('deleted_at', NULL)
->get() [0]->number_pgs;

$number_ts = DB::table('users')
->select(DB::raw('count(id) as number_pgs'))
->where('role', 4)
->where('name', "LIKE" , '%ts.%')
->where('deleted_at', NULL)
->get() [0]->number_pgs;

$number_ths = DB::table('users')
->select(DB::raw('count(id) as number_pgs'))
->where('role', 4)
->where('name', "LIKE" , '%ths.%')
->where('deleted_at', NULL)
->get() [0]->number_pgs;


// $registed_topic = DB::table('topics')
// ->select(DB::raw('count(id) as number_registed_topic'))
// ->where('status', 0)
// ->get();
// $number_registed_topic = $registed_topic[0]->number_registed_topic;

// $topic_status = DB::table('topics')
// ->select(DB::raw('count(id) as number_topic, status'))
// ->where('topics.academic_year', '=', $khoa_hoc)
// ->groupBy('status')
// ->get();
// $number_registed_topic = $topic_status[0]->number_topic;
// $total_topic = (int)$topic_status[0]->number_topic + (int)$topic_status[1]->number_topic;
// $register_percent = (int)(((int)$number_registed_topic / (int)$total_topic)*100);

$number_registed_topic = DB::table('user_register_topics')
->select(DB::raw('count(id) as number_topic'))
->where('user_register_topics.semester', '=', $khoa_hoc)
->get();

$total_topic = DB::table('topics')
->select(DB::raw('count(id) as total_topic'))
->where('topics.academic_year', '=', $khoa_hoc)
->get();

$number_registed_topic = (int)$number_registed_topic[0]->number_topic;
$total_topic = (int)$total_topic[0]->total_topic;

$register_percent = ($total_topic != 0) ? (int)(($number_registed_topic / $total_topic)*100) : '--';
// if ($total_topic != 0)
//     $register_percent = (int)(($number_registed_topic / $total_topic)*100);
// else
//     $register_percent = '--';

// $topic_register_time = DB::table('time_configs')->where('name', 'topic_register')->first();
$start = $configurations->reg_open_date;
$end = $configurations->reg_close_date;
$end_time = strtotime($end);

$start_date = new DateTime($start);//start time
$end_date = new DateTime($end);//end time

// dd($start_date);

$year = idate('Y', $end_time); 
$month = idate('m', $end_time);
$day = idate('d', $end_time);
$hour = idate('h', $end_time);
$minute = idate('m', $end_time);
$second = idate('s', $end_time);
// echo $year.' - '.$month.' - '.$day.' - '.$hour.' - '.$minute.' - '.$second;

$current_date_time = Carbon::now();
if ($start_date > $current_date_time) {
    $interval = $start_date->diff($current_date_time);              //thời gian còn lại
    $time_to_register = $interval->format('%D Ngày %H Giờ %I Phút %S Giây');   
}
if ($current_date_time >= $start_date && $current_date_time < $end_date) {
    $interval2 = $end_date->diff($current_date_time);
    $time_left = $interval2->format('%D Ngày %H Giờ %I Phút %S Giây');
}
?>

<body>
    <!-- Main content -->
    <div class="main-content" id="panel">
        <!-- Topnav -->
        <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Search form -->
                    <!-- <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
                            <div class="form-group mb-0">
                            <div class="input-group input-group-alternative input-group-merge">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input class="form-control" placeholder="Search" type="text">
                            </div>
                            </div>
                            <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main"
                            aria-label="Close">
                            <span aria-hidden="true">×</span>
                            </button>
                        </form> -->
                        <a class="" href="{{ url('/') }}">
                            <img class="logo_banner" style="" src="{{ asset('banner.svg') }}">
                        </a>
                    <!-- Navbar links -->
                    <ul class="navbar-nav align-items-center  ml-md-auto ">
                        <li class="nav-item d-xl-none">
                            <!-- Sidenav toggler -->
                            <!-- <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin"
                                data-target="#sidenav-main">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </div> -->
                        </li>
                        <!-- <li class="nav-item d-sm-none">
                            <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                                <i class="ni ni-zoom-split-in"></i>
                            </a>
                        </li> -->
                    </ul>
                    <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
                        <li class="nav-item dropdown">
                            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <div class="media align-items-center">
                                    <span class="avatar avatar-sm rounded-circle">
                                        <img alt="Image placeholder" src="{{ asset('avatar.png') }}">
                                    </span>
                                    <div class="media-body  ml-2  d-none d-lg-block">
                                        <span class="mb-0 text-sm  font-weight-bold">{{ Auth::user()->name }}</span>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu  dropdown-menu-right ">
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Xin chào!</h6>
                                </div>
                                <!-- <a href="#!" class="dropdown-item">
                                    <i class="ni ni-single-02"></i>
                                    <span>My profile</span>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <i class="ni ni-settings-gear-65"></i>
                                    <span>Settings</span>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <i class="ni ni-calendar-grid-58"></i>
                                    <span>Activity</span>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <i class="ni ni-support-16"></i>
                                    <span>Support</span>
                                </a> -->
                                @canany(['topic-register'])
                                <a class="dropdown-item" href="{{url('topic-register-details')}}">Đề tài đã đăng ký</a>
                                @endcanany

                                @canany(['role-list', 'role-edit', 'role-create'])
                                <a class="dropdown-item" href="{{ route('roles.index') }}">Quản lý quyền</a>
                                @endcanany
                                
                                @hasrole('Quản trị viên|Giáo vụ')
                                    <a class="dropdown-item" href="{{ route('configurations.index') }}">Quản lý cấu hình</a>
                                @endhasrole

                                <a class="dropdown-item" href="{{ url('changePassword') }}">Đổi mật khẩu</a>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    <i class="ni ni-button-power"></i>{{ __('Đăng xuất') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header -->
        <!-- Header -->
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-12 col-12">
                            <h6 class="h2 text-white d-inline-block mb-0">Trang chủ</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- Card stats -->
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Đề tài đã đăng ký</h5>
                                            <span class="h2 font-weight-bold mb-0">{{ $number_registed_topic }} / {{ $total_topic }}</span>
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                                <i class="ni ni-paper-diploma"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <p class="mt-3 mb-0 text-sm">
                                            <span class="text-nowrap">Tỉ lệ đăng ký: </span>
                                            <span class="text-success mr-2" style="font-weight: bold;">{{ $register_percent }}%</span>
                                        </p>
                                        <p class="mt-3 mb-0 text-sm col text-right">
                                            <a href="{{ route('topic-register-result') }}" class="btn btn-sm btn-success">Xem chi tiết</a>
                                        </p>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Bộ môn</h5>
                                            <span class="h2 font-weight-bold mb-0">5</span>
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                                <i class="ni ni-building"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <!-- <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 0%</span>
                                        <span class="text-nowrap">1 tháng trước</span> -->
                                        <span class="badge badge-primary">CNPM</span>
                                        <span class="badge badge-info">KHMT</span>
                                        <span class="badge badge-success">HTTT</span>
                                        <span class="badge badge-danger">KTMT</span>
                                        <span class="badge badge-warning">PPGD</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">GVHD</h5>
                                            <span class="h2 font-weight-bold mb-0">{{ $number_gvhd }}</span>
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                                <i class="ni ni-satisfied"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <span class="badge badge-danger">{{ $number_pgs }} PGS TS</span>
                                        <span class="badge badge-warning">{{ $number_ts }} TS</span>
                                        <span class="badge badge-success">{{ $number_ths }} ThS</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Sinh viên</h5>
                                            <span class="h2 font-weight-bold mb-0">{{ $number_sv }}</span>
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                                <i class="ni ni-badge"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <!-- <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 12%</span>
                                        <span class="text-nowrap">2 tuần trước</span> -->
                                        <!-- <span class="badge badge-primary"></span>  -->
                                        <span class="badge badge-info">CNTT</span>
                                        <!-- <span class="badge badge-danger">2 PGS TS</span> -->
                                        <!-- <span class="badge badge-warning">8 TS</span> -->
                                        <span class="badge badge-success">SP Tin học</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-md-12 text-align-center h1">
                            @if ($current_date_time > $start_date && $current_date_time < $end_date)
                            <span id="topic_register_time" style="white-space: normal;" class="badge badge-warning h1">
                                Sinh viên còn {{$time_left}} để đăng ký khóa luận
                            </span>
                            @elseif ($current_date_time < $start_date && $current_date_time < $end_date)
                            <span style="white-space: normal;" class="badge badge-warning h1">
                                Đăng kí khóa luận sẽ được mở sau {{$time_to_register}}
                            </span>
                            @else
                            
                            @endif
                        </div>
                    </div>
                    <!-- <script>
                        // Set the date we're counting down to
                        // var countDownDate = new Date("Jan 5, 2022 15:37:25").getTime();
                        var countDownDate = new Date(Date.UTC('{{$year}}', '{{$month}}' - 1, '{{$day}}', 
                        '{{$hour}}', '{{$minute}}', '{{$second}}')).getTime();
                        console.log(countDownDate);
                        // Update the count down every 1 second
                        var x = setInterval(function() {
                            // Get today's date and time
                            var now = new Date().getTime();
                            console.log(now);
                            // Find the distance between now and the count down date
                            var distance = countDownDate - now;
                                
                            // Time calculations for days, hours, minutes and seconds
                            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                
                            // Output the result in an element with id="demo"
                            document.getElementById("topic_register_time").innerHTML = 'Sinh viên còn ' + days + " ngày " + hours + " giờ "
                            + minutes + " phút " + seconds + " giây " + ' để đăng ký khóa luận';
                                
                            // If the count down is over, write some text 
                            if (distance < 0) {
                                clearInterval(x);
                                document.getElementById("topic_register_time").innerHTML = "Đã hết thời gian đăng kí khóa luận tốt nghiệp";
                            }
                        }, 1000);
                    </script> -->
                </div>
            </div>
        </div>
    </div>
        <!-- Page content -->
        <div class="container-fluid mt--6">
            <div class="row">
                <div class="col-xl-12">
                    <div id="app">
                        @yield('content')
                    </div>       
                </div>
            </div>
        </div>
            <div style="height: 200px;"></div>
            <!-- Footer -->
            <footer class="py-5 bg-dark" id="footer-main">
                <div class="container">
                    <div class="row align-items-center justify-content-xl-between">
                        <div class="col-xl-12">
                            <div class="copyright text-center text-xl-center text-muted">
                                &copy; 2023 <a href="http://fit.hnue.edu.vn/" class="font-weight-bold ml-1"
                                    target="_blank">Khoa Công nghệ thông tin - Trường Đại học Sư phạm Hà Nội</a>
                            </div>
                        </div>
                        <!-- <div class="col-xl-6">
                            <ul class="nav nav-footer justify-content-center justify-content-xl-end">
                                <li class="nav-item">
                                    <a href="https://www.creative-tim.com" class="nav-link" target="_blank">Creative Tim</a>
                                </li>
                                <li class="nav-item">
                                    <a href="https://www.creative-tim.com/presentation" class="nav-link" target="_blank">About
                                        Us</a>
                                </li>
                                <li class="nav-item">
                                    <a href="http://blog.creative-tim.com" class="nav-link" target="_blank">Blog</a>
                                </li>
                                <li class="nav-item">
                                    <a href="https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md"
                                        class="nav-link" target="_blank">MIT License</a>
                                </li>
                            </ul>
                        </div> -->
                    </div>
                </div>
            </footer>
        {{-- </div> --}}
    {{-- </div> --}}

    


    <script src="{{ asset('js/toastr.min.js') }}"></script>
    {!! Toastr::message() !!}
    <!-- Argon Scripts -->
    <!-- Core -->
    <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/js-cookie/js.cookie.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
    <!-- Optional JS -->
    <script src="{{ asset('assets/vendor/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/dist/Chart.extension.js') }}"></script>
    <!-- Argon JS -->
    <script src="{{ asset('assets/js/argon.js?v=1.2.0') }}"></script>
    <script src="{{ asset('assets/js/myFunction.js') }}"></script>
    
</body>

</html>