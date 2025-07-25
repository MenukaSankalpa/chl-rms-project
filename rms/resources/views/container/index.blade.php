@extends('layout.app')
@section('style')
    <style>
        th {
            font-size: 12px;
        }
        tr {
            font-size: 12px;
        }
    </style>
@endsection
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Bulk Edit Plug On Containers <a href="{{url('/container/create')}}"
                                                                      class="btn btn-primary btn-sm"><i
                class="fa fa-plus-square"></i> New Container / Upload Excel</a></h1>

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
                {{--       <div class="card-header py-3">
                           <h6 class="m-0 font-weight-bold text-primary"></h6>
                       </div>--}}
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                {{--Search form start--}}
                                <div class="col-md-12 mb-2{{-- border-right--}}" name="search_box">
                                    <h6 class="m-0 font-weight-bold text-center">SEARCH</h6>

                                    <div class="row">

                                        <div class="col-md-4">

                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label>Vessel</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select required name="ext_search[vessel_id]"
                                                            class="form-control form-control-sm" data-live-search="true"
                                                            tabindex="1">
                                                        <option value=''>[SELECT]</option>
                                                        @foreach($vessels as $vessel)
                                                            <option value="{{$vessel->id}}">{{$vessel->name}}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label>Loading/Discharging</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="ext_search[loading_discharging]"
                                                            class="form-control form-control-sm"
                                                            data-live-search="true" tabindex="4">
                                                        <option value="B">[Both]</option>
                                                        <option value="L">Loading</option>
                                                        <option value="D">Discharging</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3">Plug on</div>
                                                <div class="col-md-3">
                                                    <input type="checkbox" class="form-control form-control-sm"
                                                           name="ext_search[plug_on]">
                                                </div>
                                                <div class="col-md-3">Plug off</div>
                                                <div class="col-md-3">
                                                    <input type="checkbox" class="form-control form-control-sm"
                                                           name="ext_search[plug_off]">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label>Voyage</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select required name="ext_search[voyage_id]"
                                                            class="form-control form-control-sm" data-live-search="true"
                                                            tabindex="2">
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label>Yard Location</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" name="ext_search[yard_location]"
                                                           class="form-control form-control-sm" tabindex="5"
                                                           required>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label>Container Number</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control form-control-sm"
                                                           name="ext_search[container_number]"
                                                           id="search_container_number"
                                                           placeholder="Container Number"
                                                           maxlength="11"
                                                           tabindex="3"
                                                           required>
                                                </div>

                                            </div>

                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label>Plug On Date</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group date" id="datetimepicker4"
                                                         data-target-input="nearest">
                                                        <input type="text" name="search_plug_on_date"
                                                               class="form-control form-control-sm datetimepicker-input"
                                                               data-target="#datetimepicker4" tabindex="9"/>
                                                        <div class="input-group-append" data-target="#datetimepicker4"
                                                             data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="row">

                                    </div>

                                    <hr>
                                    <button class="btn btn-primary btn-sm" name="search" tabindex="17"><i
                                            class="fa fa-search"></i> Search
                                    </button>

                                </div>
                                {{--Search Form End--}}

                                {{--Edit form start--}}
                                <div class="col-md-12 mb-2 {{--border-left-dark--}}" name="edit_box">
                                    <h6 class="m-0 font-weight-bold text-center"> EDIT</h6>
                                    <div class="row">
                                        <div class="col-md-12" style="color: red; font-size: x-small"
                                             name="validation_box"></div>
                                        <div class="col-md-4">

                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label>Vessel</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select required name="vessel_id" id="vessel_id"
                                                            class="form-control form-control-sm"
                                                            data-live-search="true"
                                                            tabindex="1">
                                                        <option value=''>[SELECT]</option>
                                                        @foreach($vessels as $vessel)
                                                            <option value="{{$vessel->id}}">{{$vessel->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label>Loading/Discharging</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="loading_discharging"
                                                            class="form-control form-control-sm"
                                                            data-live-search="true" tabindex="4">
                                                        <option value="L">Loading</option>
                                                        <option value="D">Discharging</option>
                                                    </select>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label>Voyage</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select required name="voyage_id" id="voyage_id"
                                                            class="form-control form-control-sm"
                                                            data-live-search="true"
                                                            tabindex="2">
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label>Quick Save</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="checkbox" class="form-control form-control-sm"
                                                           name="with_">
                                                </div>

                                            </div>
                                        </div>

                                    </div>


                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                        <div name="bulk_edit_tools">
                                            <button class="btn btn-success btn-sm" name="save_changes" tabindex="17"><i
                                                    class="fa fa-save"></i> Apply Changes
                                            </button>
                                            <button class="btn btn-primary btn-sm" name="revert_changes" tabindex="17">
                                                <i
                                                    class="fa fa-redo-alt"></i> Revert Changes
                                            </button>
                                            <button class="btn btn-danger btn-sm" name="delete_selection" tabindex="17">
                                                <i
                                                    class="fa fa-trash"></i> Delete Selection
                                            </button>
                                        </div>
                                        </div>
                                        <div class="float-right col-md-6">
                                            {{--<input type="checkbox" class=""--}}
                                                   {{--name="bulk_bulk_edit_toggle"><small><strong>Buk Edit tools</strong></small>--}}
                                        </div>

                                        <div class="col-md-8">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <small style="font-weight: bold">Plug off date</small>
                                                    <input type="checkbox" class="" name="toggle_plug_off_date"
                                                           data-col-index="9">
                                                </div>
                                                <div class="col-md-2">
                                                    <small style="font-weight: bold">RDT temp</small>
                                                    <input type="checkbox" class="" name="toggle_rdt_temp"
                                                           data-col-index="10">
                                                </div>
                                                <div class="col-md-2">
                                                    <small style="font-weight: bold">Remarks</small>
                                                    <input type="checkbox" class="" name="toggle_remarks"
                                                           data-col-index="11">
                                                </div>
                                                <div class="col-md-2">
                                                    <small style="font-weight: bold">Edit/Delete</small>
                                                    <input type="checkbox" class="" name="toggle_actions"
                                                           data-col-index="13">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                {{--Edit form End--}}

                            </div>
                        </div>
                        {{--<div class="col-md-2 mb-2">--}}
                            {{--<div class="card border-left-primary">--}}
                                {{--<strong>Last Edit On</strong>--}}
                                {{--<ul name="edits" class="list-group" style=" height:200px; overflow-y: scroll;">--}}

                                {{--</ul>--}}

                            {{--</div>--}}
                        {{--</div>--}}

                        <div class="col-md-12 border-top pt-2">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm table-striped table-active"
                                       id="containerTable" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                    <tr>
                                        <th></th>
                                        {{--<th></th>--}}
                                        <th>container number</th>
                                        <th>Yard Location</th>
                                        <th>Category</th>
                                        <th>Temp Unit</th>
                                        <th>Set Temp</th>
                                        <th>Plug on Date</th>
                                        <th>Plug on time</th>
                                        <th>Plug on temp</th>
                                        <th>Plug off Date</th>
                                        <th>RDT Temp</th>
                                        <th>Remarks</th>
                                        <th>Quick Save</th>
                                        <th>Action</th>
                                    </tr>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th></th>
                                        {{--<th></th>--}}
                                        <th>container number</th>
                                        <th>Yard Location</th>
                                        <th>Category</th>
                                        <th>Temp Unit</th>
                                        <th>Set Temp</th>
                                        <th>Plug on Date</th>
                                        <th>Plug on time</th>
                                        <th>Plug on temp</th>
                                        <th>Plug off Date</th>
                                        <th>RDT Temp</th>
                                        <th>Remarks</th>
                                        <th>Quick Save</th>
                                        <th>Action</th>
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
        </div>

    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {

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
                }).always(function (d) {
                    $('select[name=voyage_id]').selectpicker('refresh');
                });
            });

            //on document load triggers one time.
            $('select[name=vessel_id]').trigger('change');

            $('select[name="ext_search[vessel_id]"]').bind('change', function (e) {

                var vessel = $(this).val();
                $('select[name="ext_search[voyage_id]"]').empty();
                $('select[name="ext_search[voyage_id]"]').append($("<option value=''>[SELECT]</option>"));

                $.ajax({
                    url: '{{url('api/voyage')}}/' + vessel,
                    method: 'get',
                }).done(function (voyage_list) {
                    $.each(voyage_list.data, function (k, v) {
                        $('select[name="ext_search[voyage_id]"]').append($(v.option_element));
                    });
                }).always(function (d) {
                    $('select[name="ext_search[voyage_id]"]').selectpicker('refresh');
                });
            });

            //on document load triggers one time.
            $('select[name="ext_search[vessel_id]"]').trigger('change');

            $('#datetimepicker4').datetimepicker({
                format: 'YYYY-MM-DD',
            });

            $('#datetimepicker3').datetimepicker({
                format: 'HH:mm'
            });
            $('select').selectpicker();
        });
    </script>

    <script>
        //todo - validate select inputs Load discharge ts local only allow default values -done
        //todo - Bulk edit controller. done
        $(document).ready(function () {
            //updates edits list
            function update_edits_list() {
                $.ajax({
                    method: 'get',
                    url: '{{url('/bulk_edit_stack')}}'
                }).done(function (d) {
                    //console.log(d);
                    $('ul[name=edits]').empty();
                    $.each(d, function (k, v) {
                        var options = v;
                        //console.log(options);
                        $('ul[name=edits]').append($('<li class="list-group-item"><small>' + options.created_at + '</small></li>'));
                    });
                });
            }

            //on document load loads edits list
            update_edits_list();

            //bulk edit toggle
            $('input[name="bulk_bulk_edit_toggle"]').click(function () {
                $('div[name="bulk_edit_tools"]').toggle();
            });

            //save edited changes
            $('div[name=edit_box] button[name=save_changes]').click(function (e) {
                if (!$('select[name=vessel_id]')[0].checkValidity()) {
                    $('div[name=validation_box]').empty();
                    $('div[name=validation_box]').html("Vessel Cannot be Empty")
                } else if (!$('select[name=voyage_id]')[0].checkValidity()) {
                    $('div[name=validation_box]').empty();
                    $('div[name=validation_box]').html("Voyage Cannot be Empty")
                } else {
                    var data = $('div[name=edit_box]').find('input,select').add($('div[name=search_box]').find('input,select'));
                    //console.log(data.serialize())
                    $.ajax({
                        method: 'POST',
                        url: '{{url('bulk_edit')}}',
                        data: data.serialize()
                    }).always(function () {
                        update_edits_list();
                        table.ajax.reload(null, false);//reload table without changing user paging
                    }).done(function (d) {
                        d = JSON.parse(d);
                        var success = '';
                        var errors = '';
                        console.log(d.success);
                        console.log(d.errors);
                        console.log(d);
                        $.each(d.success, function (k, v) {
                            success += '<li style="color:green"><pre>' + v + '</pre></li>';
                        });
                        $.each(d.errors, function (k, v) {
                            errors += '<li style="color:red"><pre>' + v + '</pre></li>';
                        });
                        var list = $("<ul>" + success + errors + "</ul>");
                        console.log(list);
                        $('#standardModal').find('#ModalLabel').html('Edit Complete.');
                        $('#standardModal').find('#modalBody').html(list);
                        $('#standardModal').modal('show');
                    });
                }
            });

            //revert previous changes
            $('div[name=edit_box] button[name=revert_changes]').click(function () {
                if (!$('select[name=vessel_id]')[0].checkValidity()) {
                    $('div[name=validation_box]').empty();
                    $('div[name=validation_box]').html("Vessel Cannot be Empty")
                } else if (!$('select[name=voyage_id]')[0].checkValidity()) {
                    $('div[name=validation_box]').empty();
                    $('div[name=validation_box]').html("Voyage Cannot be Empty")
                } else {

                    if (confirm('Do you want to revert changes ?')) {
                        $.ajax({
                            method: 'post',
                            url: '{{url('/bulk_revert')}}'
                        }).always(function () {
                            update_edits_list();
                            table.ajax.reload(null, false);//reload table without changing user paging
                        }).done(function (d) {
                            d = JSON.parse(d);
                            var success = '';
                            var errors = '';
                            console.log(d.success);
                            console.log(d.errors);
                            console.log(d);
                            $.each(d.success, function (k, v) {
                                success += '<li style="color:green"><pre>' + v + '</pre></li>';
                            });
                            $.each(d.errors, function (k, v) {
                                errors += '<li style="color:red"><pre>' + v + '</pre></li>';
                            });
                            var list = $("<ul>" + success + errors + "</ul>");
                            console.log(list);
                            $('#standardModal').find('#ModalLabel').html('Revert Complete.');
                            $('#standardModal').find('#modalBody').html(list);
                            $('#standardModal').modal('show');
                        });
                    }
                }
            });

            //Delete Selection changes
            $('div[name=edit_box] button[name=delete_selection]').click(function () {
                if (!$('select[name=vessel_id]')[0].checkValidity()) {
                    $('div[name=validation_box]').empty();
                    $('div[name=validation_box]').html("Vessel Cannot be Empty")
                } else if (!$('select[name=voyage_id]')[0].checkValidity()) {
                    $('div[name=validation_box]').empty();
                    $('div[name=validation_box]').html("Voyage Cannot be Empty")
                } else {

                    var data = $('div[name=edit_box]').find('input,select').add($('div[name=search_box]').find('input,select'));

                    var vessel_name = $("select[name='ext_search[vessel_id]'] option:selected").html();
                    var voyage_name = $("select[name='ext_search[voyage_id]'] option:selected").html();
                    var loading_discharging = $("select[name='ext_search[loading_discharging]'] option:selected").html();
                    var plug_on = $("input[name='ext_search[plug_on]'] ").is(':checked');
                    var plug_off = $("input[name='ext_search[plug_off]'] ").is(':checked');
                    var container_number = $("input[name='ext_search[container_number]']").val();
                    var yard_location = $("input[name='ext_search[yard_location]']").val();
                    var plug_on_date = $("input[name='search_plug_on_date']").val();

                    if (confirm('You are About to Delete \n Vess:' + vessel_name +
                        "\n Voy: " + voyage_name +
                        "\n loading_discharging:" + loading_discharging +
                        "\n plug_on:" + plug_on +
                        "\n plug_off:" + plug_off +
                        "\n container_number:" + container_number +
                        "\n Yard Location:" + yard_location +
                        "\n Plug On Date:" + plug_on_date +
                        '\nDo you want to DELETE ? After deletion data !! CAN NOT !! be recovered !')) {
                        $.ajax({
                            method: 'post',
                            url: '{{url('/bulk_delete')}}',
                            data: data.serialize()
                        }).always(function () {
                            update_edits_list();
                            table.ajax.reload(null, false);//reload table without changing user paging
                        }).done(function (d) {
                            d = JSON.parse(d);
                            var success = '';
                            var errors = '';
                            console.log(d.success);
                            console.log(d.errors);
                            console.log(d);
                            $.each(d.success, function (k, v) {
                                success += '<li style="color:green"><pre>' + v + '</pre></li>';
                            });
                            $.each(d.errors, function (k, v) {
                                errors += '<li style="color:red"><pre>' + v + '</pre></li>';
                            });
                            var list = $("<ul>" + success + errors + "</ul>");
                            console.log(list);
                            $('#standardModal').find('#ModalLabel').html('Delete Complete.');
                            $('#standardModal').find('#modalBody').html(list);
                            $('#standardModal').modal('show');
                        });
                    }
                }
            });

            //when searched from the dedicated top search box following happens
            $('div[name=search_box]').delegate('button', 'click', function (event) {
                table.ajax.reload(null, false);//reload table without changing user paging
                //$('div[name=bulk_edit_tools]').show(); //show bulk edit tools
            });
            //on change event for top search
            $('div[name=search_box]').delegate('input,select', 'change', function (event) {
                //$('div[name=bulk_edit_tools]').hide(); //hide toos until search is preformed
            });
            //by default bulk edit tools are hidden
            $('div[name=bulk_edit_tools]').hide();

            //togglr columns
            //other column toggles
            $.each($('input[name^=toggle_]'),function (k,v) {
                $(v).on('click', function (e) {
                    // Get the column API object
                    var column = table.column($(this).data('col-index'));
                    if($(this).is(':checked')) {
                        column.visible(true);
                    }else{
                        column.visible(false);
                    }

                });
            });



            window.table = $('#containerTable').DataTable({
                processing: true,
                serverSide: true,
                keys:true,
                // rowReorder: {
                //     selector: 'td:nth-child(2)'
                // },
                responsive: true,
                pageLength: 25,
                "lengthMenu": [[10, 25, 50,100,500,1000], [10, 25, 50,100,500,1000]],
                // responsive: {
                //     details: {
                //         display: $.fn.dataTable.Responsive.display.childRowImmediate,
                //         type: 'none',
                //         target: ''
                //     }
                // },
                "columnDefs": [
                    {"visible": false, "targets": 9},
                    {"visible": false, "targets": 10},
                    {"visible": false, "targets": 11},
                    {"visible": false, "targets": 13}
                ],
                columns: [
                    {data: 'empty', orderable: false, searchable: false, all: true},
                    //{data: 'with_vessel_voyage', orderable: false, searchable: false, all: true},
                    {data: 'container_number'},
                    {data: 'yard_location', orderable: false},
                    // {data: 'loading_discharging'},
                    {data: 'ts_local', orderable: false},
                    {data: 'temperature_unit', orderable: false,width:'2%'},
                    {data: 'set_temp', orderable: false},
                    {data: 'plug_on_date'},
                    {data: 'plug_on_time', orderable: false},
                    {data: 'plug_on_temp', orderable: false},
                    {data: 'plug_off_date', orderable: false},
                    {data: 'rdt_temp', orderable: false},
                    {data: 'remarks', orderable: false,width:'2%'},
                    {data: 'quick_save', orderable: false, searchable: false, all: true},
                    {data: 'action', orderable: false, searchable: false, all: true}
                ],
                "ajax": {
                    "url": '{{url('data/container')}}',
                    "type": 'POST',
                    "data": function (d) {
                        d.extra_search = $('div[name=search_box]').find("input,select").serialize();//additional search parameters from search boxes
                    },
                },
            }).on('init.dt draw', function () {
                //console.log( 'Table initialisation complete: '+new Date().getTime() );
                //Loading Discharging Validation
                $('#containerTable').find('input[name=loading_discharging]').each(function (k, v) {
                    $(v).change(function (e) {
                        if ($(this).val().charAt(0).toUpperCase() == 'D') {
                            $(this).val('D');
                        } else if ($(this).val().charAt(0).toUpperCase() == 'L') {
                            $(this).val('L');
                        } else {
                            $(this).val('');
                        }

                    });
                });

                //TS LOCAL Validation
                $('#containerTable').find('input[name=ts_local]').each(function (k, v) {
                    $(v).change(function (e) {
                        if ($(this).val().charAt(0).toUpperCase() == 'T') {
                            $(this).val('TS');
                        } else if ($(this).val().charAt(0).toUpperCase() == 'I') {
                            $(this).val('IMP');
                        } else if ($(this).val().charAt(0).toUpperCase() == 'E') {
                            $(this).val('EXP');
                        } else {
                            $(this).val('');
                        }

                    });
                });
                //Temperature unit Validation
                $('#containerTable').find('input[name=temperature_unit]').each(function (k, v) {
                    $(v).change(function (e) {
                        if ($(this).val().charAt(0).toUpperCase() == 'C') {
                            $(this).val('C');
                        } else if ($(this).val().charAt(0).toUpperCase() == 'F') {
                            $(this).val('F');
                        } else {
                            $(this).val('');
                        }

                    });
                });

                //time format correction
                $('#containerTable').find('input[name=plug_on_time]').each(function (k, v) {
                    $(v).change(function (e) {
                        $(this).val(timeFormat($(this).val())==false?'':timeFormat($(this).val()));
                    });
                });

            })//arrow key tab function
                .on( 'key-focus', function ( e, datatable, cell, originalEvent ) {
                    $(cell.node()).find('input,button').focus();
                });

            //quick save validation
            function quic_save_validation(tr){
                var elem = [];
                var notification_box_variables = {
                    globalPosition: "bottom left",
                    autoHideDelay: 5000,
                    showDuration: 250,
                    hideDuration: 250,
                }
                var error_count = 0;
                $.each(tr.find('input'),function (k,v) {
                    elem[$(v).attr('name')] = $(v);
                })

                //container number empty
                if(elem['container_number'].val()==''){
                    error_count ++;
                    $.notify(
                        "Container number Cannot be Empty",
                        notification_box_variables
                    );
                }
                //container number not 11
                if(elem['container_number'].val().length!=11){
                    error_count ++;
                    $.notify(
                        "Container number Must contain 11 characters",
                        notification_box_variables
                    );
                }
                //empty yard location
                if(elem['yard_location'].val()==''){
                    error_count ++;
                    $.notify(
                        "Yard location cannot be empty",
                        notification_box_variables
                    );
                }
                //empty Category
                if(elem['ts_local'].val()==''){
                    error_count ++;
                    $.notify(
                        "Category cannot be empty",
                        notification_box_variables
                    );
                }
                //empty temperature unit
                if(elem['temperature_unit'].val()==''){
                    error_count ++;
                    $.notify(
                        "Temperature unit cannot be empty",
                        notification_box_variables
                    );
                }
                //set Temp
                if(elem['set_temp'].val()==''){
                    error_count ++;
                    $.notify(
                        "Set temperature cannot be empty",
                        notification_box_variables
                    );
                }
                // //set Temp
                // if(elem['rdt_temp'].val()==''){
                //     error_count ++;
                //     $.notify(
                //         "RDT temperature cannot be empty",
                //         notification_box_variables
                //     );
                // }
                //plug on date
                if(elem['plug_on_date'].val()==''){
                    error_count ++;
                    $.notify(
                        "Plug on date cannot be empty",
                        notification_box_variables
                    );
                }
                //plug on date
                if(!isValidDate(elem['plug_on_date'].val())){
                    error_count ++;
                    $.notify(
                        "Plug On Date format not valid",
                        notification_box_variables
                    );
                }
                //plug on time
                if(elem['plug_on_time'].val()==''){
                    error_count ++;
                    $.notify(
                        "Plug on Time cannot be empty",
                        notification_box_variables
                    );
                }
                //plug on time
                if(!isValidTime(elem['plug_on_time'].val())){
                    error_count ++;
                    $.notify(
                        "Plug on Time format not valid",
                        notification_box_variables
                    );
                }

                //plug on temp
                if(elem['plug_on_temp'].val()==''){
                    error_count ++;
                    $.notify(
                        "Plug on Temperature cannot be empty",
                        notification_box_variables
                    );
                }

                // //plug off date
                // if(elem['plug_off_date'].val()==''){
                //     error_count ++;
                //     $.notify(
                //         "Plug off date cannot be empty",
                //         notification_box_variables
                //     );
                // }
                // //plug off date
                // if(!isValidDate(elem['plug_off_date'].val())){
                //     error_count ++;
                //     $.notify(
                //         "Plug off Date format not valid",
                //         notification_box_variables
                //     );
                // }

                if(error_count>0){
                    return false;
                }else{
                    return true;
                }
            }
            //on quick save button click
            $('#containerTable').delegate('#quick_save', 'click', function (e) {

                //e.preventDefault();
                var this_button = $(this);
                var table_row = $(this).closest('tr');

                var quic_save_vss = $('input[name=with_]').is(':checked');

                var edit_box = $('div[name=edit_box]').find('input,select');

                //console.log(edit_box);
                //responsive data tables davide table row into two parts in small displays
                //to compensate that following is done
                if (table_row.hasClass('child')) {
                    //tis will take the first pat from two parts and serialize
                    var other_part = table_row.prev('tr').clone();//make clone so original row will not be affect
                    other_part.find('input[value=DELETE]').remove();
                    var tr_clone = table_row.clone();//make a clone of table row where button is on
                    tr_clone.find('input[value=DELETE]').remove();

                    //each input elemnt in the other part corresponding to table row is replaced by the table row element
                    $.each(tr_clone.find('input,select'), function (k, v) {
                        var duplicate_element_name = $(v).prop("tagName") + '[name=' + $(v).attr('name') + ']';
                        other_part.find(duplicate_element_name).remove();
                    });
                    var data = other_part.add(tr_clone).find('input,select');//combine both parts to create complete row

                    other_part.remove();//remove clones
                    tr_clone.remove();

                } else {
                    //this will serialize the row if two parts were not found
                    var tr_clone = table_row.clone();
                    tr_clone.find('input[value=DELETE]').remove();
                    data = tr_clone.find('input,select');

                    tr_clone.remove();
                }

                //if vessel voyage quic save is allowed
                if (quic_save_vss) {
                    data = data.add(edit_box);
                }

                // var with_ = $("<div></div>").append(data).find('input[name=with_]').is(':checked');
                // console.log(with_);
                //vessel voyage validation
                if (!$('#vessel_id').get(0).checkValidity() && quic_save_vss) {
                    $('#vessel_id').notify(
                        "Vessel Cannot be Empty",
                        {
                            position: "top",
                            autoHideDelay: 5000,
                            showDuration: 250,
                            hideDuration: 250,
                        }
                    );
                    e.preventDefault()
                } else if (!$('#voyage_id').get(0).checkValidity() && quic_save_vss) {
                    $('#voyage_id').notify(
                        "Voyage Cannot be Empty",
                        {
                            position: "top",
                            autoHideDelay: 5000,
                            showDuration: 250,
                            hideDuration: 250,
                        }
                    );
                    e.preventDefault()
                } else {

                    //quick save error handling
                    if (quic_save_validation(table_row)) {


                        //data is posted to update
                        $.ajax({
                            method: 'post',
                            url: '{{url('row_update')}}/' + this_button.data('id'),
                            data: data.serialize()
                        }).done(function (d) {
                            if (d.id) {
                                $.notify(
                                    'Success: ' +
                                    (d.container_number || '') +
                                    "\n Vessel:" + (d.vessel ? d.vessel.name || '' : '') +
                                    " Voyage:" + (d.voyage ? d.voyage.code || '' : '') +
                                    "\n loading_vessel:" + (d.loading_vessel ? d.loading_vessel.name || '' : '') +
                                    " Loading_voyage:" + (d.loading_voyage ? d.loading_voyage.code || '' : '') +
                                    " \n Yard:" + (d.yard_location || '') +
                                    " Category:" + (d.ts_local || '') +
                                    " \n Temp Unit:" + (d.temperature_unit || '') +
                                    " Temp Unit:" + (d.plug_on_date || '') + '....'
                                    ,
                                    {
                                        globalPosition: 'bottom left',
                                        autoHideDelay: 15000,
                                        showDuration: 250,
                                        hideDuration: 250,
                                        hideAnimation: 'slideUp',
                                        style: 'bootstrap',
                                        className: 'success',
                                    }
                                );
                            } else {
                                console.log(JSON.parse(d));
                                var data = JSON.parse(d);
                                var error_list = '';
                                $.each(data.error, function (k, v) {
                                    error_list += '\n' + v;
                                });
                                $.notify(
                                    'Error: ' + error_list
                                    ,
                                    {
                                        globalPosition: 'bottom left',
                                        autoHideDelay: 15000,
                                        showDuration: 250,
                                        hideDuration: 250,
                                        hideAnimation: 'slideUp',
                                        style: 'bootstrap',
                                        className: 'error',
                                    }
                                );
                            }
                            //alert('Container:' + d.container_number + " updated vessel voyage applyied");
                        }).fail(function (d) {//on update fail
                            window.alert(JSON.stringify(d));//error alert to user
                        }).always(function (jqXHR) { //under any condition
                            table.ajax.reload(null, false);//reload table without changing user paging
                        });
                    }else{
                        //reload table after 6 seconds
                        // setTimeout(function(){
                        //     table.ajax.reload(null, false);
                        // }, 5600);
                    }
                }

            });


        });

    </script>
    <script>

    </script>
@endsection
