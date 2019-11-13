<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>@yield('title')</title>
    <!-- Favicon-->
    <link rel="icon" href="/themes/admin/favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="/themes/admin/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="/themes/admin/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="/themes/admin/css/style.css" rel="stylesheet">
</head>

<body class="five-zero-zero">
<div class="five-zero-zero-container">

    @yield('content')

    <div class="button-place">
        <a href="javascript:window.history.back();" class="btn btn-primary btn-lg waves-effect">Trang trước</a>
        <a href="/" class="btn btn-default btn-lg waves-effect">TRANG CHỦ</a>
    </div>
</div>

<!-- Jquery Core Js -->
<script src="/themes/admin/plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap Core Js -->
<script src="/themes/admin/plugins/bootstrap/js/bootstrap.js"></script>

<!-- Waves Effect Plugin Js -->
<script src="/themes/admin/plugins/node-waves/waves.js"></script>
</body>

</html>