<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="user-id" content="{{ Auth::check()? Auth::user()->id:'null' }}">
    <meta name="user-role" content="{{ Auth::check()? Auth::user()->role:'null' }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{config('app.name')}}</title>

    <!-- Custom fonts for this template-->
    {{--<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">--}}
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
          rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    {{--<link href="css/sb-admin-2.min.css" rel="stylesheet">--}}

    <!-- data table css-->
    <link href="{{asset('css/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/rowReorder.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/dataTables.checkboxes.css')}}" rel="stylesheet">
    <link href="{{asset('css/keyTable.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/keyTable.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/buttons.dataTables.min.css')}}" rel="stylesheet">

    <!-- Tempdominus date time picker css-->
    <link href="{{asset('css/tempusdominus-bootstrap-4.css')}}" rel="stylesheet">

    <!-- Bootstrap select date time picker css-->
    <link href="{{asset('css/bootstrap-select.css')}}" rel="stylesheet">

    <!-- Bootstrap select date time picker css-->
    <link href="{{asset('css/all.min.css')}}" rel="stylesheet">

    <!--Jexcel spreadsheet-->
    <link href="{{asset('css/jquery.jexcel.min.css')}}" rel="stylesheet">

    @yield('style')

</head>

<body id="page-top" class="sidebar-toggled">

<!-- Page Wrapper -->
<div id="wrapper">
    <span id="app"></span>


    @section('side_bar')
    <!-- Sidebar -->
    @include('inc.sidebar')
    <!-- End of Sidebar -->
    @show
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column" >

        <!-- Main Content -->
        <div id="content" >
            @section('nav_bar')
            <!-- Topbar -->
            @include('inc.navbar')
            <!-- End of Topbar -->
            @show
            <!-- Begin Page Content -->
            <div class="container-fluid" {{--id="app"--}}>
                @section('messages')
                <!-- messages -->
                @include('inc.messages')
                <!-- end of messages -->
                @show

                @yield('content')

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->
        @section('footer')
        <!-- Footer -->
        @include('inc.footer')
        <!-- End of Footer -->
        @show
    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
@include('inc.modal')
<!-- Bootstrap core JavaScript-->
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/bootstrap.bundle.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
{{--<script src="vendor/jquery/jquery.min.js"></script>--}}
{{--<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>--}}

<!-- Core plugin JavaScript-->
<script src="{{asset('js/jquery.easing.js')}}"></script>
{{--<script src="vendor/jquery-easing/jquery.easing.min.js"></script>--}}

<!-- Custom scripts for all pages-->
<script src="{{asset('js/sb-admin-2.js')}}"></script>
{{--<script src="{{asset('js/fontawesome.js')}}"></script>--}}

{{--<CK Editor>--}}
{{--<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>--}}
{{--<script>--}}
    {{--CKEDITOR.replace( 'article-ckeditor' );--}}
{{--</script>--}}
{{--<End CK Editor>--}}

{{--<data tables js>--}}
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
{{--<data tables bootstrap js >--}}
<script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('js/dataTables.rowReorder.min.js')}}"></script>
<script src="{{asset('js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('js/dataTables.checkboxes.min.js')}}"></script>
<script src="{{asset('js/dataTables.keyTable.min.js')}}"></script>
<script src="{{asset('js/keyTable.bootstrap4.min.js')}}"></script>
<script src="{{asset('js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('js/buttons.print.min.js')}}"></script>
<script src="{{asset('js/buttons.colVis.min.js')}}"></script>
{{--End data table js--}}
{{--<Moment js date time validation>--}}
<script src="{{asset('js/moment.js')}}"></script>
{{--End moment js--}}
{{--<tempus Tempdominus datetime picker js >--}}
<script src="{{asset('js/tempusdominus-bootstrap-4.js')}}"></script>
{{--End date time picker js--}}
{{--<bootstrap select >--}}
<script src="{{asset('js/bootstrap-select.js')}}"></script>
{{--
<script src="{{asset('js/i18n/defaults-*.min.js')}}"></script>
--}}
<script src="{{asset('js/i18n/defaults-en_US.min.js')}}"></script>
{{--End bootstrap select--}}
{{--Notify js--}}
<script src="{{asset('js/notify.min.js')}}"></script>

{{--Jexcel--}}
<script src="{{asset('js/jquery.jexcel.min.js')}}"></script>


{{--Jquery Validation --}}
<script src="{{asset('js/jquery.validate.min.js')}}"></script>

{{--Custom scripts--}}
<script src="{{asset('js/custom.js')}}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

@yield('script')
{{--Data table--}}
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
{{--end data table--}}
{{--<Active Link>--}}
<script>
    $(document).ready(function () {
        var nav_items = $(this).find('li.nav-item');
        nav_items.each(function (index) {
            //console.log($(this).children('a').attr('href'));
            //console.log(window.location.pathname);
            var href = $(this).children('a').attr('href');
            href = href.replace(/\//g,"\\/");
            //console.log(href);
            var expression = eval('/'+href+'[a-zA-Z0-9/=?&_%]*/');
            var res = window.location.href.match(expression);
            if(res){
                $(this).addClass('active');
            }
        });
        var collapse_items = $(this).find('a.collapse-item');
        collapse_items.each(function (index) {
            //console.log(window.location.href);
            var href = $(this).attr('href');
            href = href.replace(/\//g,"\\/");
            //console.log(href);
            var expression = eval('/'+href+'[a-zA-Z0-9/=?&_%]*/');
            var res = window.location.href.match(expression);
            //console.log(expression,res);
            if(res){
                $(this).parent().parent().addClass('show')
                $(this).addClass('active',true);
            }
        });

    });
</script>
{{--<End active link>--}}
</body>

</html>

