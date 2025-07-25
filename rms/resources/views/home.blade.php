@extends('layout.app')
@section('style')
    <style>
        .card-bg-white{
            background-color: #ffffff;
        }
        .spinner {
            -webkit-animation:spin 4s linear infinite;
            -moz-animation:spin 4s linear infinite;
            animation:spin 4s linear infinite;
        }
        @-moz-keyframes spin { 100% { -moz-transform: rotate(360deg); } }
        @-webkit-keyframes spin { 100% { -webkit-transform: rotate(360deg); } }
        @keyframes spin { 100% { -webkit-transform: rotate(360deg); transform:rotate(360deg); } }
    </style>
@endsection
@section('content')
    <!-- Page Heading -->
    <div class="mb-4">
        @auth('web')
            <h6>Logged in as User</h6>
        @endauth
        @auth('admin')
            <h6>Logged in As Admin</h6>
        @endauth
        <h1 class="h3 mb-0 text-gray-800">
            Welcome to Ceyline RMS {{Auth::user()->name}} !
        </h1>
    </div>

    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 card-bg-white">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Currently Monitoring
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$monitoring_count}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 card-bg-white">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Plug Only
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$plug_only_count}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 card-bg-white">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Plug Off This Month
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$plug_off_this_month}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2 card-bg-white">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Missing Monitoring</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" id="ratio">0/{{$monitoring_count}}</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" id="missing_monitoring_progress" style="width: 50%"
                                             aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300 spinner" id="image"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12 col-sm-12 mb-4">
            <div class="card shadow-lg">
                <div class="card-header"></div>
                <div class="card-body">
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        let monitoring_count = '{{$monitoring_count}}';
        $.ajax({
            method:'get',
            url:'{{url('/missing_monitoring_count')}}',
            beforeSend: function(){
                $('#image').addClass("spinner");
                $('#missing_monitoring_progress').css('width','0%')
            },

            success: function(data){
                var d = JSON.parse(data);
                $('#image').removeClass("spinner");
                $('#ratio').html(d.missing_monitoring_count+'/'+d.monitoring_count);
                $('#missing_monitoring_progress').css('width',d.percentage+'%')
            }
        })
    </script>
@endsection
