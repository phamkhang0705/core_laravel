<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Deal365 | @yield('title')</title>

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

    <!-- Morris Chart Css-->
    <link href="{{ asset('themes/admin/plugins/morrisjs/morris.css') }}" rel="stylesheet"/>

    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="{{ asset('themes/admin/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}"
          rel="stylesheet"/>
    <link href="{{ asset('themes/admin/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet">

    <!-- Bootstrap Select Css -->
    <link href="{{ asset('themes/admin/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet"/>

    <!-- Bootstrap Tagsinput Css -->
    <link href="{{ asset('themes/admin/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet">


    <!-- select2 Css -->
    <link href="{{ asset('themes/admin/plugins/select2/css/select2.css') }}" rel="stylesheet"/>

    <!-- bootstrap-table Css -->
    <link href="{{ asset('themes/admin/plugins/bootstrap-table/bootstrap-table.min.css') }}" rel="stylesheet"/>

    <!-- Wait Me Css -->
    <link href="{{ asset('themes/admin/plugins/waitme/waitMe.css') }}" rel="stylesheet"/>

    <!-- JQuery Nestable Css -->
    <link href="{{ asset('themes/admin/plugins/nestable/jquery-nestable.css') }}" rel="stylesheet"/>

    <link href="{{ asset('themes/admin/plugins/chosen/chosen.min.css') }}" rel="stylesheet"/>

    <link href="{{ asset('themes/admin/plugins/datepicker/bootstrap-datetimepicker.css') }}" rel="stylesheet"/>

    <!-- light image -->
    <link href="{{ asset('themes/admin/plugins/light-gallery/css/lightgallery.css') }}" rel="stylesheet">

    @section('header.style')
    @show

    <link href="{{ asset('themes/admin/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('themes/admin/css/custom.css') }}" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{ asset('themes/admin/css/themes/all-themes.css') }}" rel="stylesheet"/>
</head>

<body class="theme-red">

<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<!-- #END# Overlay For Sidebars -->

<!-- Search Bar -->
<div class="search-bar">
    <div class="search-icon">
        <i class="material-icons">search</i>
    </div>
    <input type="text" placeholder="START TYPING...">
    <div class="close-search">
        <i class="material-icons">close</i>
    </div>
</div>
<!-- #END# Search Bar -->

<!-- Top Bar -->
@include('cms.element.nav')
<!-- #Top Bar -->

@include('cms.element.aside')

<section class="content">
    <div class="container-fluid">
        @if(!empty($breadcrumb))
            <div class="row m-b-10">
                <ol class="breadcrumb p-t-0">
                    <li>
                        <a href="{{action('Cms\Dashboard@index')}}">
                            <i class="material-icons">home</i> Trang chủ
                        </a>
                    </li>
                    @foreach($breadcrumb as $item)
                        @if(isset($item['active']) && $item['active'] == true)
                            <li class="active wrapword">
                                {{isset($item['title'])?$item['title']:'Unknown'}}
                            </li>
                        @else
                            <li class="wrapword">
                                <a href="{{isset($item['url'])?$item['url']:'#'}}">
                                    {{isset($item['title'])?$item['title']:'Unknown'}}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ol>
            </div>
        @endif

        @yield('content')

    </div>
    @include('cms.element.dialog')

</section>

<!-- Jquery Core Js -->
<script src="{{ asset('themes/admin/plugins/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap Core Js -->
<script src="{{ asset('themes/admin/plugins/bootstrap/js/bootstrap.js') }}"></script>

<!-- Select Plugin Js -->
<script src="{{ asset('themes/admin/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>

<!-- Slimscroll Plugin Js -->
<script src="{{ asset('themes/admin/plugins/jquery-slimscroll/jquery.slimscroll.js') }}"></script>

<!-- Waves Effect Plugin Js -->
<script src="{{ asset('themes/admin/plugins/node-waves/waves.js') }}"></script>

<!-- Jquery CountTo Plugin Js -->
<script src="{{ asset('themes/admin/plugins/jquery-countto/jquery.countTo.js') }}"></script>

<!-- Morris Plugin Js -->
<script src="{{ asset('themes/admin/plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('themes/admin/plugins/morrisjs/morris.js') }}"></script>

<!-- ChartJs -->
<script src="{{ asset('themes/admin/plugins/chartjs/Chart.bundle.js') }}"></script>

<!-- Flot Charts Plugin Js -->
<script src="{{ asset('themes/admin/plugins/flot-charts/jquery.flot.js') }}"></script>
<script src="{{ asset('themes/admin/plugins/flot-charts/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('themes/admin/plugins/flot-charts/jquery.flot.pie.js') }}"></script>
<script src="{{ asset('themes/admin/plugins/flot-charts/jquery.flot.categories.js') }}"></script>
<script src="{{ asset('themes/admin/plugins/flot-charts/jquery.flot.time.js') }}"></script>

<!-- Sparkline Chart Plugin Js -->
<script src="{{ asset('themes/admin/plugins/jquery-sparkline/jquery.sparkline.js') }}"></script>

<!-- Autosize Plugin Js -->
<script src="{{ asset('themes/admin/plugins/autosize/autosize.js') }}"></script>

<!-- Moment Plugin Js -->
<script src="{{ asset('themes/admin/plugins/momentjs/moment.js') }}"></script>

<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="{{ asset('themes/admin/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>

<script src="{{ asset('themes/admin/plugins/daterangepicker/daterangepicker.js') }}"></script>

<!-- SweetAlert Plugin Js -->
<script src="{{ asset('themes/admin/plugins/sweetalert/sweetalert.min.js') }}"></script>
 

<!-- Ckeditor -->
<script src="{{ asset('themes/admin/plugins/ckeditor/ckeditor.js') }}"></script>

<!-- Bootstrap Tags Input Plugin Js -->
<script src="{{ asset('themes/admin/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>

<!-- Jquery Nestable -->
<script src="{{ asset('themes/admin/plugins/nestable/jquery.nestable.js') }}"></script>

<script src="{{ asset('themes/admin/plugins/waitme/waitMe.js') }}"></script>

<!-- Multi Select Css -->
<link href="{{ asset('themes/admin/plugins/multi-select/css/multi-select.css') }}" rel="stylesheet">

<!-- Multi Select Plugin Js -->
<script src="{{ asset('themes/admin/plugins/multi-select/js/jquery.multi-select.js') }}"></script>

<!-- Bootstrap Notify Plugin Js -->
<script src="{{ asset('themes/admin/plugins/bootstrap-notify/bootstrap-notify.js') }}"></script>

<script src="{{ asset('themes/admin/plugins/datepicker/bootstrap-datetimepicker.js') }}"></script>

<script src="{{ asset('themes/admin/plugins/jquery-validation/jquery.validate.js') }}"></script>
<script src="{{ asset('themes/admin/plugins/jquery-validation/additional-methods.js') }}"></script>
<script src="{{ asset('themes/admin/plugins/jquery-validation/localization/messages_vi.js') }}"></script>
<script src="{{ asset('cms/js/validate.js') }}"></script>

<script src="{{ asset('themes/admin/plugins/jquery-inputmask/jquery.inputmask.bundle.js') }}"></script>

<script src="{{ asset('themes/admin/plugins/chosen/chosen.jquery.js') }}"></script>

<script src="{{ asset('themes/admin/plugins/handlebars/handlebars.js') }}"></script>
{{-- select 2 --}}
<script src="{{ asset('themes/admin/plugins/select2/js/select2.min.js') }}"></script>
{{-- bootstrap-table --}}
<script src="{{ asset('themes/admin/plugins/bootstrap-table/bootstrap-table.min.js') }}"></script>
<script src="{{ asset('themes/admin/plugins/bootstrap-table/bootstrap-table-local-df.js') }}"></script>

<!-- Light Gallery Plugin Js -->
<script src="{{ asset('themes/admin/plugins/light-gallery/js/lightgallery-all.js') }}"></script>

<script src="{{asset('themes/admin/plugins/chosen/docsupport/prism.js')}}" type="text/javascript"
        charset="utf-8"></script>
<script src="{{asset('themes/admin/plugins/chosen/docsupport/init.js')}}" type="text/javascript"
        charset="utf-8"></script>


@section('footer.script')

    <!-- Custom Js -->
    <script src="{{ asset('themes/admin/js/admin.js') }}"></script>
    <script src="{{ asset('themes/admin/js/app.js') }}"></script>
    <script src="{{ asset('themes/admin/js/comm.js') }}"></script>

    <script type="text/javascript">
        $(function () {
            
            var date = new Date();
            date.setDate(date.getDate());

            $('[data-toggle="tooltip"]').tooltip({
                container: 'body'
            });

            $('[data-toggle="popover"]').popover();

            $('.multi-select').multiSelect({selectableOptgroup: true});

            $('.datetimepicker').bootstrapMaterialDatePicker({
                format: 'YYYY-MM-DD HH:mm',
                clearButton: true,
                weekStart: 1
            });

            $('.datepicker').bootstrapMaterialDatePicker({
                format: 'DD/MM/YYYY',
                clearButton: true,
                weekStart: 1,
                time: false
            });

            $('.need_focus').focus();

            $('._datetime_').datetimepicker({
                sideBySide: true,
                format: 'YYYY-MM-DD HH:mm'
            });

            $('._datetime_1_').datetimepicker({
                sideBySide: true,
                format: 'HH:mm DD/MM/YYYY',
                useCurrent: false
            });

            $('._datetime_2_').datetimepicker({
                sideBySide: true,
                format: 'HH:mm DD/MM/YYYY',
                useCurrent: false,
                minDate: date
            });

            $('._date_1_').datetimepicker({
                sideBySide: true,
                format: 'DD/MM/YYYY'
            });

            $('._time_1_').datetimepicker({
                sideBySide: true,
                format: 'HH:mm'
            });

            $('._date_').datetimepicker({
                sideBySide: true,
                format: 'YYYY-MM-DD'
            });
            
            $('._date1_ ').datetimepicker({
                sideBySide: true,
                format: 'DD/MM/YYYY',
                useCurrent: false
            });

            $('._hour_ ').datetimepicker({
                sideBySide: true,
                format: 'HH:mm'
            });

            $('.timepicker').bootstrapMaterialDatePicker({
                format: 'HH:mm',
                clearButton: true,
                date: false
            });
        });
        $(function () {
            $('.thumb-light-gallery').lightGallery({
                thumbnail: true,
                selector: 'a.show'
            });
        });
    </script>


@show

<div id="mask">
    <div class="content">
        <div class="preloader pl-size-sm">
            <div class="spinner-layer pl-grey">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

</html>