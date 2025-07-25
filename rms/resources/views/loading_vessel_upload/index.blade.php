@extends('layout.app')
@section('content')
    <!-- Page Heading -->
    <a href="{{url('/read/loading_vessel_excel/')}}" class=""><i class="fa fa-arrow-alt-circle-left"></i> Go Back </a>
    <h1 class="h3 mb-4 text-gray-800">Upload Loading Vessel </h1>

    <div class="row">
        <div class="col-md-12">
            @if(session('message'))
                @if(count(session('message')) > 0)
                    @foreach(session('message') as $k=>$type)

                        @if($k == 'warning')
                            @if(count($type)>0)
                                @foreach($type as $error_msg)
                                    <div class="alert alert-warning">
                                        <pre>{{$error_msg}}</pre>
                                    </div>
                                @endforeach
                            @endif
                        @endif

                        @if($k == 'error')
                            @if(count($type)>0)
                                @foreach($type as $error_msg)
                                    <div class="alert alert-danger">
                                        <pre>{{$error_msg}}</pre>
                                    </div>
                                @endforeach
                            @endif
                        @endif

                        @if($k == 'success')
                            @if(count($type)>0)
                                @foreach($type as $error_msg)
                                    <div class="alert alert-success">
                                        <pre>{{$error_msg}}</pre>
                                    </div>
                                @endforeach
                            @endif
                        @endif

                    @endforeach
                @endif
            @endif

            {{--data table--}}
            <div class="card shadow mb-4">
                {{--<div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"></h6>
                </div>--}}
                <div class="card-body">
                    <form action="{{url('/upload')}}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="row">
                        <div class="col-md-4">

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label>Vessel</label>
                                </div>
                                <div class="col-md-6">
                                    <select required name="vessel_id" class="form-control form-control-sm" data-live-search="true" tabindex="1">
                                        <option value=''>[SELECT]</option>
                                        @foreach($vessels as $vessel)
                                            <option value="{{$vessel->id}}" >{{$vessel->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label>file</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="file" name="upload_file">
                                </div>
                                {{--redirect target contains the path of the reader controller that will read the uploaded file.--}}
                                <input type="hidden" name="redirect_target" value="/read/loading_vessel_excel/">
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label>Voyage</label>
                                </div>
                                <div class="col-md-6">
                                    <select required name="voyage_id" class="form-control form-control-sm" data-live-search="true" tabindex="2">
                                    </select>
                                </div>

                            </div>


                        </div>
{{--                        <div class="col-md-4">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label>Temperature Unit</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="temperature_unit" class="form-control form-control-sm"
                                            data-live-search="true" tabindex="6">
                                        <option value="C">Celsius (&#176;C)</option>
                                        <option value="F">Fahrenheit (&#176;F)</option>
                                    </select>
                                </div>

                            </div>

                        </div>--}}

                            <div class="col-md-4">
                            </div>

                        </div>
                        <hr>
                            <button type="submit" class="btn btn-success btn-sm">Upload EXCEL</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>


        $(document).ready(function() {

            $('select').selectpicker();

            //vessel voyage
            $('select[name=vessel_id]').bind('change', function (e) {

                var vessel_id = $(this).val();
                $('select[name=voyage_id]').empty();
                $('select[name=voyage_id]').append($("<option value=''>[SELECT]</option>"));

                $.ajax({
                    url: '{{url('api/voyage')}}/' + vessel_id,
                    method: 'get',
                }).done(function (voyage_list) {
                    $.each(voyage_list.data, function (k, v) {
                        $('select[name=voyage_id]').append($(v.option_element));
                    });

                }).always(function () {
                    $('select[name=voyage_id]').selectpicker('refresh');
                });
            });

            //on document load triggers one time.
            $('select[name=vessel_id]').trigger('change');

            // $('#portTable').DataTable( {
            //     processing: true,
            //     serverSide: true,
            //     rowReorder: {
            //         selector: 'td:nth-child(2)'
            //     },
            //     responsive: true,
            //     "ajax": 'data/port',
            //     columns: [
            //         { data: 'code'},
            //         { data: 'name'},
            //         { data: 'action', orderable: false, searchable: false}
            //     ]
            // } );
        } );
    </script>
@endsection