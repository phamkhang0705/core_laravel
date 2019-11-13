@extends('cms.layouts.default')

@section('title', "Danh sách menu")

@section('content')
    <style type="text/css">
        .col-lg-12, .col-lg-5, .col-lg-7 {
            padding: 0;
        }
    </style>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">

                    <div class="body table-responsive" style="padding-bottom: 150px;">

                        @include('cms.element.alert')

                        <div style="min-height: 50px" id="editable_wrapper" class="dataTables_wrapper form-inline list-menu">
                            @include('cms.element.loading',[])
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @include('cms.element.button_create', ['url'=>action('Cms\Menu@create'),'tooltip'=>'Tạo menu mới'])


@stop
@section('footer.script')

    @parent
    <script type="text/javascript">
        var urlGetListMenu = "{!! url('menu/get_list_menu')!!}";

    </script>
    <script src="{{ asset('cms/js/menu.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            cms_menu.load_list_menu();
        });
    </script>
@endsection