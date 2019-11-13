<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Sign In</title>
    <!-- Favicon-->
    <link rel="icon" href="{{ asset('themes/admin/favicon.ico') }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet"
          type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('themes/admin/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('themes/admin/plugins/node-waves/waves.css') }}" rel="stylesheet"/>

    <!-- Animation Css -->
    <link href="{{ asset('themes/admin/plugins/animate-css/animate.css') }}" rel="stylesheet"/>

    <!-- Sweetalert Css -->
    <link href="{{ asset('themes/admin/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet"/>

    <!-- Custom Css -->
    <link href="{{ asset('themes/admin/css/style.css') }}" rel="stylesheet">
</head>

<body class="login-page">
<div class="login-box">
    <div class="logo">
        <a href="javascript:void(0);">deal365.vn</a>
    </div>
    <div class="card">
        <div class="body">
            <div class="cms_element_alert">
            @include('cms.element.alert')
            </div>

            <form id="sign_in" method="POST" action="{{action('Cms\Auth@login')}}">

                {{ csrf_field() }}

                <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                    <div class="form-line">
                        <input type="text" class="form-control" name="name" placeholder="Username" required autofocus>
                    </div>
                </div>
                <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                    <div class="form-line">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4 p-t-5">

                    </div>
                    <div class="col-xs-4">
                        <button class="btn btn-block bg-pink waves-effect" type="submit" disabled>Đăng nhập</button>
                    </div>
                    <div class="col-xs-4">
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-4">

                    </div>
                    <div class="col-xs-6">
                        <a href="" class="forget-password">Quên mật khẩu?</a>
                    </div>
                    <div class="col-xs-3">
                        
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Jquery Core Js -->
<script src="{{ asset('themes/admin/plugins/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap Core Js -->
<script src="{{ asset('themes/admin/plugins/bootstrap/js/bootstrap.js') }}"></script>

<!-- Waves Effect Plugin Js -->
<script src="{{ asset('themes/admin/plugins/node-waves/waves.js') }}"></script>

<!-- Validation Plugin Js -->
<script src="{{ asset('themes/admin/plugins/jquery-validation/jquery.validate.js') }}"></script>

<!-- SweetAlert Plugin Js -->
<script src="{{ asset('themes/admin/plugins/sweetalert/sweetalert.min.js') }}"></script>

<script src="{{ asset('themes/admin/js/comm.js') }}"></script>

<!-- Custom Js -->
{{--<script src="{{ asset('themes/admin/js/cms.js') }}"></script>--}}
<script src="{{ asset('themes/admin/js/pages/examples/sign-in.js') }}"></script>
</body>

</html>