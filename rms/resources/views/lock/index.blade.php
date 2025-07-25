@extends('layout.app')
@section('style')
    <style>
        th {
            font-size: 12px;
        }

        tr {
            font-size: 12px;
        }
        .dt-right{
            text-align: right;
        }
    </style>
@endsection
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">
        @section('_title')
            Container Lock
        @show</h1>

    <div class="row">
        <div class="col-md-12">
            {{--data table--}}
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            {{--Search form start--}}
                            <form id="search_form" action="{{url('/upload')}}" enctype="multipart/form-data"
                                  method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 mb-2" name="search_box">

                                        <div class="row">

                                            <div class="col-md-4">

                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label>Start Date</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group date" id="datetimepicker4"
                                                             data-target-input="nearest">
                                                            <input type="text" name="from"
                                                                   value="{{\Carbon\Carbon::now()->startOfMonth()->toDateString()}}"
                                                                   class="form-control form-control-sm datetimepicker-input"
                                                                   data-target="#datetimepicker4" tabindex="9"
                                                            />
                                                            <div class="input-group-append"
                                                                 data-target="#datetimepicker4"
                                                                 data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i
                                                                        class="fa fa-calendar"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label>End Date</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group date" id="datetimepicker5"
                                                             data-target-input="nearest">
                                                            <input type="text" name="to"
                                                                   value="{{\Carbon\Carbon::now()->endOfMonth()->toDateString()}}"
                                                                   class="form-control form-control-sm datetimepicker-input"
                                                                   data-target="#datetimepicker5" tabindex="9"
                                                            />
                                                            <div class="input-group-append"
                                                                 data-target="#datetimepicker5"
                                                                 data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i
                                                                        class="fa fa-calendar"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <div class="col-md-4">Others</div>
                                                    <div class="col-md-3">
                                                        <input type="checkbox" class="form-control form-control-sm"
                                                               name="monitoring" checked>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <div class="col-md-4">MEARSK</div>
                                                    <div class="col-md-3">
                                                        <input type="checkbox" class="form-control form-control-sm"
                                                               name="plug_only" >
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <hr>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <button class="btn btn-primary btn-sm" name="form_search"
                                                            tabindex="17">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>
                                                </div>
                                                <div class="col-md-4">
                                                </div>
                                                <div class="col-md-4 float-right">
                                                    <button class="btn btn-success btn-sm" name="lock"
                                                            tabindex="17">
                                                        <i class="fa fa-lock"></i> Lock date range
                                                    </button>
                                                    <button class="btn btn-danger btn-sm" name="unlock"
                                                            tabindex="17">
                                                        <i class="fa fa-lock-open"></i> Unlock date range
                                                    </button>
                                                </div>



                                            </div>
                                            <div class="col-md-8">
                                                <div class="row">
                                                    @section('toggle_column_check_boxes')
                                                    <div class="col-md-2">
                                                        <small style="font-weight: bold">Empty</small>
                                                        <input type="checkbox" class="" name="toggle_container_number"
                                                               data-col-index="0">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <small style="font-weight: bold">container no.</small>
                                                        <input type="checkbox" class="" name="toggle_container_number"
                                                               data-col-index="1" checked>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <small style="font-weight: bold">Plug On Date</small>
                                                        <input type="checkbox" class="" name="toggle_plug_on_date"
                                                               data-col-index="2" checked>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <small style="font-weight: bold">Plug On time</small>
                                                        <input type="checkbox" class="" name="toggle_plug_on_time"
                                                               data-col-index="3" checked>
                                                    </div>

                                                        @show
                                                </div>
                                            </div>
                                            @section('key')
                                            @show
                                        </div>

                                    </div>
                                </div>

                            </form>
                            {{--Search Form End--}}

                        </div>

                        <div class="col-md-12 border-top pt-2">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm table-striped table-active"
                                       id="containerTable" width="100%" cellspacing="0">
                                    @section('thead')
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>container no.</th>
                                        <th>Plug on Date</th>
                                        <th>Plug on time</th>
                                        <th>Plug off Date</th>
                                        <th>Plug off time</th>
                                        <th>Monitor or Plug</th>
                                        <th>Lock/Unlock Container</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>container no.</th>
                                        <th>Plug on Date</th>
                                        <th>Plug on time</th>
                                        <th>Plug off Date</th>
                                        <th>Plug off time</th>
                                        <th>Monitor or Plug</th>
                                        <th>Lock/Unlock Container</th>
                                    </tr>
                                    </tfoot>
                                    @show
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('script')

    <script>
        var notification_box_variables = {
            globalPosition: "bottom left",
            autoHideDelay: 5000,
            showDuration: 250,
            hideDuration: 250,
        }
    </script>
    <script>
        $(document).ready(function () {

            var voyage_id = '@yield('voyage_id')';
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
                        $('select[name=voyage_id]').append($(voyage_option));
                    });
                }).always(function (d) {
                    $('select[name=voyage_id]').selectpicker('refresh');
                });
            });


            $('#datetimepicker4').datetimepicker({
                format: 'YYYY-MM-DD',
                icons: {
                    time: "fa fa-clock",
                }
            });
            $('#datetimepicker5').datetimepicker({
                format: 'YYYY-MM-DD',
                icons: {
                    time: "fa fa-clock",
                }
            });

        });
    </script>
<i class="fa fa-clo">
    <script>
        //Validations

        $(document).ready(function () {


            //add attribut to form as wich button was clicked
            $.each($('#search_form').find('button[name^=form_]'), function (k, v) {
                $(v).click(function (e) {
                    $('#search_form').data('submit-button', $(v).attr('name'));
                })
            });
            //when searched from the dedicated top search box following happens
            $('#search_form').submit(function (event) {
                if ($(event.target).data('submit-button') == 'form_search') {
                    event.preventDefault();
                    table.ajax.reload(null, false);//reload table without changing user paging
                }
            });


            //other column toggles
            $.each($('input[name^=toggle_]'), function (k, v) {
                $(v).on('click', function (e) {
                    // Get the column API object
                    var column = table.column($(this).data('col-index'));

                    if ($(this).is(':checked')) {
                        column.visible(true);
                        table.ajax.reload(null, false);//reload table without changing user paging
                    } else {
                        column.visible(false);
                    }
                });
            });

            var table = $('#containerTable').DataTable({
                processing: true,
                serverSide: true,
                keys:true,
                pageLength: 25,
                "lengthMenu": [[25,50,100,200,500,1000,-1], ['25','50','100','200','500','1000',"All"]],
                responsive: true,
                @section('dt_col')
                "columnDefs": [
                    {"visible": false, "targets": 0},
                ],
                columns: [
                    {data: 'empty', orderable: false},
                    {data: 'container_number'},
                    {data: 'plug_on_date'},
                    {data: 'plug_on_time'},
                    {data: 'plug_off_date'},
                    {data: 'plug_off_time', orderable: false},
                    {data: 'plugging_category'},
                    {data: 'lock'},
                ],
                @show
                "ajax": {
                    "url": '{{url('data/lock')}}',
                    "type": 'POST',
                    "data": function (d) {
                        d.extra_search = $('div[name=search_box]').find("input,select").serialize() + '&file_id=@yield('file_id')';//additional search parameters from search boxes
                    },
                },

            }).on('init.dt draw', function () {
            })
                //arrow key tab function
                .on( 'key-focus', function ( e, datatable, cell, originalEvent ) {
                $(cell.node()).find('input,button').focus();
            });
            window.table = table;
///Lock and unlock by container.
            $('#containerTable').delegate('input[name=lock]','click',function (e) {
                var cont_id = $(this).data('container-id');
                console.log(cont_id);
                $.ajax({
                    method:'POST',
                    url:'{{url('/lock/')}}'+'/'+cont_id,
                    data:$(this).serialize()
                }).done(function (d) {
                    if(typeof d =='string' && 'success' in JSON.parse(d)){
                        $.notify(
                            JSON.parse(d).success,
                            {
                                globalPosition: "bottom left",
                                autoHideDelay: 10000,
                                showDuration: 250,
                                hideDuration: 250,
                                style: 'bootstrap',
                                className:'success',
                            }
                        );
                    }
                }).always(function () {
                    table.ajax.reload(null, false);//reload table without changing user paging
                });
            });

            $('button[name=lock]').click(function (e) {
                e.preventDefault();
                var data = $('#search_form').serialize();

                $.ajax({
                   method:'post',
                   url:'bulk_lock',
                   data: data+'&lock_option=lock'
                }).done(function (d) {
                    if(typeof d =='string' && 'success' in JSON.parse(d)){
                        $.notify(
                            JSON.parse(d).success,
                            {
                                globalPosition: "bottom left",
                                autoHideDelay: 5000,
                                showDuration: 250,
                                hideDuration: 250,
                                style: 'bootstrap',
                                className: 'success'
                            }
                        );
                    }
                }).always(function () {
                    table.ajax.reload(null, false);//reload table without changing user paging
                });
            })
            $('button[name=unlock]').click(function (e) {
                e.preventDefault();
                var data = $('#search_form').serialize();

                $.ajax({
                    method:'post',
                    url:'bulk_lock',
                    data: data+'&lock_option=unlock'
                }).done(function (d) {
                    if(typeof d =='string' && 'success' in JSON.parse(d)){
                        $.notify(
                            JSON.parse(d).success,
                            {
                                globalPosition: "bottom left",
                                autoHideDelay: 10000,
                                showDuration: 250,
                                hideDuration: 250,
                                style: 'bootstrap',
                                className: 'success'
                            }
                        );
                    }
                }).always(function () {
                    table.ajax.reload(null, false);//reload table without changing user paging
                });
            })


        });

    </script>
@endsection
