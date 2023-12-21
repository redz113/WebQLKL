<!--
=========================================================
* Argon Dashboard - v1.2.0
=========================================================
* Product Page: https://www.creative-tim.com/product/argon-dashboard

* Copyright  Creative Tim (http://www.creative-tim.com)
* Coded by www.creative-tim.com
=========================================================
* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="Creative Tim">
    <title>Hệ thống đăng ký khóa luận tốt nghiệp - Khoa Công nghệ thông tin - Trường Đại học Sư phạm Hà Nội</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('fithnue.png') }}" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}"
        type="text/css">
    <!-- Argon CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/argon.css?v=1.2.0') }}" type="text/css">
</head>

<body class="bg-default">
    <!-- Navbar -->
    <nav id="navbar-main" class="navbar navbar-horizontal navbar-transparent navbar-main navbar-expand-lg navbar-light">
        <div class="container">
            <a class="" href="{{ url('/') }}">
                <img class="logo_banner" style="" src="{{ asset('banner.svg') }}">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse"
                aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse navbar-custom-collapse collapse" id="navbar-collapse">
                <div class="navbar-collapse-header">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('banner_white.svg') }}">
                            </a>
                        </div>
                        <div class="col-6 collapse-close">
                            <button type="button" class="navbar-toggler" data-toggle="collapse"
                                data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a href="dashboard.html" class="nav-link">
                            <span class="nav-link-inner--text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="login.html" class="nav-link">
                            <span class="nav-link-inner--text">Login</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="register.html" class="nav-link">
                            <span class="nav-link-inner--text">Register</span>
                        </a>
                    </li>
                </ul> -->
                <hr class="d-lg-none" />
                <ul class="navbar-nav align-items-lg-center ml-lg-auto">
                    <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="https://www.facebook.com/fithnuefanpage" target="_blank"
                            data-toggle="tooltip" data-original-title="Fanpage Khoa CNTT">
                            <i class="fab fa-facebook-square"></i>
                            <span class="nav-link-inner--text d-lg-none">Facebook</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="http://fit.hnue.edu.vn/"
                            target="_blank" data-toggle="tooltip" data-original-title="Website Khoa CNTT">
                            <i class="ni ni-favourite-28"></i>
                            <span class="nav-link-inner--text d-lg-none">Website</span>
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="https://twitter.com/creativetim" target="_blank"
                            data-toggle="tooltip" data-original-title="Follow us on Twitter">
                            <i class="fab fa-twitter-square"></i>
                            <span class="nav-link-inner--text d-lg-none">Twitter</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="https://github.com/creativetimofficial" target="_blank"
                            data-toggle="tooltip" data-original-title="Star us on Github">
                            <i class="fab fa-github"></i>
                            <span class="nav-link-inner--text d-lg-none">Github</span>
                        </a>
                    </li> -->
                    <!-- <li class="nav-item d-none d-lg-block ml-lg-4">
                        <a href="https://www.creative-tim.com/product/argon-dashboard-pro?ref=ad_upgrade_pro"
                            target="_blank" class="btn btn-neutral btn-icon">
                            <span class="btn-inner--icon">
                                <i class="fas fa-shopping-cart mr-2"></i>
                            </span>
                            <span class="nav-link-inner--text">Upgrade to PRO</span>
                        </a>
                    </li> -->
                </ul>
            </div>
        </div>
    </nav>
    <!-- Main content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <!-- <div class="col-xl-12 col-lg-12 col-md-12 px-5">
                            <h2 class="text-white">Khoa Công nghệ thông tin - Trường Đại học Sư phạm Hà Nội</h2>
                            <h2 class="text-lead text-white">Đăng ký khóa luận tốt nghiệp</h2>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="separator separator-bottom separator-skew zindex-100">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
                    xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>
        <!-- Page content -->
        <div class="container mt--8 pb-5">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="card bg-secondary border-0 mb-0">
                        <!-- <div class="card-header bg-transparent pb-5">
                            <div class="text-muted text-center mt-2 mb-3"><small>Sign in with</small></div>
                            <div class="btn-wrapper text-center">
                                <a href="#" class="btn btn-neutral btn-icon">
                                    <span class="btn-inner--icon"><img
                                            src="{{ asset('assets/img/icons/common/github.svg') }}"></span>
                                    <span class="btn-inner--text">Github</span>
                                </a>
                                <a href="#" class="btn btn-neutral btn-icon">
                                    <span class="btn-inner--icon"><img
                                            src="{{ asset('assets/img/icons/common/google.svg') }}"></span>
                                    <span class="btn-inner--text">Google</span>
                                </a>
                            </div>
                        </div> -->
                        <div class="card-body px-lg-5 py-lg-5">
                            <div class="text-center text-muted mb-4">
                                <h3>Đăng nhập hệ thống</h3>
                            </div>
                            <form role="form" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                        </div>
                                        <input id="login" type="text" placeholder='Tên đăng nhập / Email'
                                            class="form-control{{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}"
                                            name="login" value="{{ old('username') ?: old('email') }}" required autofocus>

                                        @if ($errors->has('username') || $errors->has('email'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('username') ?: $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input id="password" placeholder='Mật khẩu' type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Nhớ tài khoản') }}
                                    </label>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary my-4">
                                        {{ __('Đăng nhập') }}
                                    </button>    
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- <div class="row mt-3">
                        <div class="col-6">
                            <a href="#" class="text-light"><small>Forgot password?</small></a>
                        </div>
                        <div class="col-6 text-right">
                            <a href="#" class="text-light"><small>Create new account</small></a>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    <!-- Kết quả đăng ký Khóa luận -->
    <?php 
    $nien_khoa = DB::table('configurations')
                ->select('academic_year')
                ->first()->academic_year;
                

    $register_result = DB::table('user_register_topics')
        ->join('users as students', 'user_register_topics.user_id', '=', 'students.id')
        ->join('topics', 'user_register_topics.topic_id', '=', 'topics.id')
        ->join('users as instructors', 'topics.user_id', '=', 'instructors.id')
        ->select('topics.id as topic_id', 'topics.name as topic_name', 'topics.department', 
        'students.name as student_name', 'students.username as student_id', 'instructors.name as instructor_name')
        ->where('topics.academic_year', '=', $nien_khoa)
        ->orderBy('instructor_name', 'asc')
        ->get();
    $i = 0;
    ?>
    <div class="card">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0">Kết quả Đăng ký đề tài khóa luận tốt nghiệp</h3>
                </div>
                <!-- <div class="col text-right">
                    <a href="#!" class="btn btn-sm btn-primary">See all</a>
                </div> -->
            </div>
        </div>
        <div class="card-body">
            <div class="row">            
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <tr class="badge-default">
                            <th class="text-align-center">STT</th>
                            <th class="text-align-center">
                                <a class="thead" href="#">    
                                    <div class="col-xl-12">
                                        Tên đề tài  <i class="fas fa-arrows-alt-v"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="text-align-center">
                                <a class="thead" href="#">    
                                    <div class="col-xl-12">
                                        Bộ môn  <i class="fas fa-arrows-alt-v"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="text-align-center">
                                <a class="thead" href="#">    
                                    <div class="col-xl-12">
                                        Mã sinh viên  <i class="fas fa-arrows-alt-v"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="text-align-center">
                                <a class="thead" href="#">    
                                    <div class="col-xl-12">
                                        Họ tên sv  <i class="fas fa-arrows-alt-v"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="text-align-center">
                                <a class="thead" href="#">    
                                    <div class="col-xl-12">
                                        Giảng viên hướng dẫn  <i class="fas fa-arrows-alt-v"></i>
                                    </div>
                                </a>
                            </th>
                        </tr>
                        
                        @foreach ($register_result as $key => $result)
                        <tr>
                            <td class="text-align-center">{{ ++$i }}</td>
                            <td style="width: 40%;" class="align-middle">{{ $result->topic_name }}</td>  
                            <td class="text-align-center">{{ $result->department }}</td>
                            <td class="text-align-center">{{ $result->student_id }}</td>
                            <td class="text-align-center">{{ $result->student_name }}</td>
                            <td class="text-align-center">{{ $result->instructor_name }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div> 



    <!-- Footer -->
    <div class="copyright text-center text-xl-center text-muted">
        &copy; 2021 <a href="http://fit.hnue.edu.vn/" class="font-weight-bold ml-1"
            target="_blank">Khoa Công nghệ thông tin - Trường Đại học Sư phạm Hà Nội</a>
    </div>
    <!-- Argon Scripts -->
    <!-- Core -->
    <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/js-cookie/js.cookie.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
    <!-- Argon JS -->
    <script src="{{ asset('assets/js/argon.js?v=1.2.0') }}"></script>
</body>
</html>