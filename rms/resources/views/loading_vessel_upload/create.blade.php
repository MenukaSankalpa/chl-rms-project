@extends('layout.app')
@section('style')
    <style>
        th {
            font-size: 12px;
        }
    </style>
@endsection
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Assign Loading Vessel </h1>

    <div class="row">
        <div class="col-md-12">
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
                                        <select required name="vessel_id" class="form-control form-control-sm"
                                                data-live-search="true" tabindex="1">
                                            <option value=''>[SELECT]</option>
                                            @foreach($vessels as $vessel)
                                                <option value="{{$vessel->id}}" {{$vessel->id == $data->vessel_id ? 'selected':''}}>{{$vessel->name}}</option>
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
                                        <select required name="voyage_id" class="form-control form-control-sm"
                                                data-live-search="true" tabindex="2">
                                        </select>
                                    </div>

                                </div>


                            </div>
                            {{--
                                                        <div class="col-md-4">
                                                            <div class="form-group row">
                                                                <div class="col-md-6">
                                                                    <label>Temperature Unit</label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <select name="temperature_unit" class="form-control form-control-sm"
                                                                            data-live-search="true" tabindex="6">
                                                                        <option value="C" {{$data->temperature_unit=='C' ? 'selected':''}}>Celsius (&#176;C)</option>
                                                                        <option value="F" {{$data->temperature_unit=='F' ? 'selected':''}}>
                                                                            Fahrenheit (&#176;F)
                                                                        </option>
                                                                    </select>
                                                                </div>

                                                            </div>

                                                        </div>
                            --}}
                            <div class="col-md-4">
                            </div>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-success btn-sm">Upload EXCEL</button>
                    </form>
                </div>
            </div>


            {{--data table--}}
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-md-2">
                            <form method="post" action="{{url('loading_vessel_upload/'.$file->id)}}">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Save
                                </button>
                            </form>
                        </div>
                        <div class="col-md-8">
                            <strong>Vessel: {{\App\Vessel::find($data->vessel_id)->name}}
                                &nbsp;
                                Voyage: {{\App\Voyage::find($data->voyage_id)->code}}</strong>
                            <span class="small float-right" name="status"></span>
                        </div>
                        <div class="col-md-2">
                            <a href="{{url('loading_vessel_upload/')}}"
                               class="btn btn-dark btn-sm  float-right"><strong>X</strong> Cancel</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="portTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                            <tr>
                                <th>Container number</th>
                                <th>Category</th>
                                <th>Yard Location</th>
                                <th>remarks</th>
                                <th>Temp Unit</th>
                                <th>set temp</th>
                                <th>plug on temp</th>
                                <th>plug on date</th>
                                <th>plug on time</th>
                                <th>Status</th>
                            </tr>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Container number</th>
                                <th>Category</th>
                                <th>Yard Location</th>
                                <th>remarks</th>
                                <th>Temp Unit</th>
                                <th>set temp</th>
                                <th>plug on temp</th>
                                <th>plug on date</th>
                                <th>plug on time</th>
                                <th>Status</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('select').selectpicker();
            var voyage_id = '{{$data->voyage_id}}';

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
                        var voyage_option = $(v.option_element);
                        if (v.id == voyage_id) {
                            voyage_option.attr('selected', true);
                        }

                        $('select[name=voyage_id]').append(voyage_option);
                    });

                }).always(function () {
                    $('select[name=voyage_id]').selectpicker('refresh');
                });
            });

            //on document load triggers one time.
            $('select[name=vessel_id]').trigger('change');

            window.table = $('#portTable').DataTable({
                processing: true,
                serverSide: true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                pageLength: 50,
                responsive: true,
                "ajax": {
                    "url": '{{url('data/loading_vessel_upload')}}',
                    "type": 'POST',
                    "data": function (d) {
                        d.extra_search = {
                            file: '{{$file->id}}'
                        };//additional search parameters from search boxes
                    },
                },
                columns: [
                    {data: 'number', name: 'temp_containers.number'},
                    {data: 'ts_local'},
                    {data: 'yard_location'},
                    {data: 'remarks'},
                    {data: 'temperature_unit'},
                    {data: 'set_temp'},
                    {data: 'plug_on_temp'},
                    {data: 'plug_on_date'},
                    {data: 'plug_on_time'},
                    {data: 'status', orderable: false, searchable: false}
                ]
            }).on('init.dt draw', function () {
                if(window.table.ajax.json().message){
                    $('span[name=status]').empty();
                    $.each(window.table.ajax.json().message, function (k,v) {
                        if(k=='error') {
                            $('span[name=status]').append($('<span style="color:red;"><strong> ' + k + ': ' + v + ' </strong></span>'));
                        }
                        if(k=='success') {
                            $('span[name=status]').append($('<span style="color:green;"><strong > ' + k + ': ' + v + ' </strong></span>'));
                        }
                        if(k=='warning') {
                            $('span[name=status]').append($('<span style="color:orange;"><strong > ' + k + ': ' + v + ' </strong></span>'));
                        }
                        console.log(k+': '+v);
                    })
                }
            });
        });
    </script>
@endsection
