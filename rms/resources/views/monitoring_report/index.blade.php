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
            Monitoring Report
        @show</h1>

    <div class="row">
        <div class="col-md-12">
            {{--data table--}}
            <div class="card shadow mb-4">
                {{--       <div class="card-header py-3">
                           <h6 class="m-0 font-weight-bold text-primary"></h6>
                       </div>--}}
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            {{--Search form start--}}
                            <form id="search_form" action="{{url('/upload')}}" enctype="multipart/form-data"
                                  method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 mb-2{{-- border-right--}}" name="search_box">
                                        {{--<h6 class="m-0 font-weight-bold text-center">SEARCH</h6>--}}

                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label>Plug On Date From</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group date" id="datetimepicker4"
                                                             data-target-input="nearest">
                                                            <input type="text" name="date_from"
                                                                   value="@yield('date_from',\Carbon\Carbon::parse(date('Y-m-d'))->firstOfMonth())"
                                                                   class="form-control form-control-sm datetimepicker-input"
                                                                   data-target="#datetimepicker4" tabindex="9"
                                                                   required/>
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
                                                        <label>Vessel</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        @section('vessel_id')
                                                            <select name="vessel_id"
                                                                    class="form-control form-control-sm"
                                                                    data-live-search="true"
                                                                    tabindex="1">
                                                                <option value=''>[SELECT]</option>
                                                                @foreach($vessels as $vessel)
                                                                    <option
                                                                        value="{{$vessel->id}}">{{$vessel->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        @show
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label>Yard Location</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="yard_location"
                                                               class="form-control form-control-sm" tabindex="5"
                                                        >
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-4">

                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label>Plug On Date To</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group date" id="datetimepicker5"
                                                             data-target-input="nearest">
                                                            <input type="text" name="date_to"
                                                                   value="@yield('date_to',\Carbon\Carbon::parse(date('Y-m-d'))->endOfMonth())"
                                                                   class="form-control form-control-sm datetimepicker-input"
                                                                   data-target="#datetimepicker5" tabindex="9"
                                                                   required/>
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


                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label>Voyage</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select name="voyage_id"
                                                                class="form-control form-control-sm"
                                                                data-live-search="true"
                                                                tabindex="2">
                                                            <option value="">[SELECT]</option>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <div class="col-md-4">Plug on</div>
                                                    <div class="col-md-3">
                                                        <input type="checkbox" class="form-control form-control-sm"
                                                               name="plug_on" @yield('plug_on')>
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
                                                               name="container_number"
                                                               id="search_container_number"
                                                               placeholder="Container Number"
                                                               maxlength="11"
                                                               tabindex="3">
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
                                                            <option value="B" @yield('ld_both')>[Both]</option>
                                                            <option value="L" @yield('ld_loading')>Loading</option>
                                                            <option value="D" @yield('ld_discharging')>Discharging
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-4">Plug off</div>
                                                    <div class="col-md-3">
                                                        <input type="checkbox" class="form-control form-control-sm"
                                                               name="plug_off" @yield('plug_off')>
                                                    </div>
                                                </div>


                                            @section('box_owner')
                                                    {{--<div class="form-group row">--}}
                                                        {{--<div class="col-md-6">--}}
                                                            {{--<label>Box Owner</label>--}}
                                                        {{--</div>--}}
                                                        {{--<div class="col-md-6">--}}
                                                            {{--<select name="box_owner"--}}
                                                                    {{--class="form-control form-control-sm"--}}
                                                                    {{--data-live-search="true" tabindex="16" >--}}
                                                                {{--<option value="">[SELECT]</option>--}}
                                                                {{--@foreach($box_owners as $box_owner)--}}
                                                                    {{--<option--}}
                                                                        {{--value="{{$box_owner->id}}">{{$box_owner->name}}</option>--}}
                                                                {{--@endforeach--}}
                                                            {{--</select>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                @show

                                                {{--<div class="form-group row">--}}
                                                    {{--<div class="col-md-6">--}}
                                                        {{--<label>Search from File</label>--}}
                                                    {{--</div>--}}
                                                    {{--<div class="col-md-6">--}}
                                                        {{--<input type="file" name="upload_file">--}}
                                                    {{--</div>--}}
                                                    {{--redirect target contains the path of the reader controller that will read the uploaded file.--}}
                                                    {{--<input type="hidden" name="redirect_target"--}}
                                                           {{--value="@yield('redirect_link','/read/reefer_monitoring_excel/')">--}}
                                                    {{--<input type="hidden" name="plug_cat" value="@yield('plug_cat','monitoring')">--}}
                                                {{--</div>--}}

                                            </div>

                                        </div>
                                        <hr>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <button class="btn btn-primary btn-sm" name="form_search"
                                                            tabindex="17">
                                                        <i
                                                            class="fa fa-search"></i> Search
                                                    </button>
                                                </div>
                                                <div class="col-md-4">
                                                </div>

                                                {{--<div class="col-md-4 ">--}}
                                                    {{--<button type="submit" name="form_upload"--}}
                                                            {{--class="btn btn-success btn-sm float-right"--}}
                                                            {{--value="Upload EXCEL" --}}{{--formnovalidate--}}{{-->Upload EXCEL--}}
                                                    {{--</button>--}}
                                                {{--</div>--}}
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row">
                                                    @section('toggle_column_check_boxes')
                                                    <div class="col-md-2">
                                                        <small style="font-weight: bold">Empty</small>
                                                        <input type="checkbox" class="" name="toggle_container_number"
                                                               data-col-index="0" checked>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <small style="font-weight: bold">Vessel</small>
                                                        <input type="checkbox" class="" name="toggle_container_number"
                                                               data-col-index="1" checked>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <small style="font-weight: bold">Voyage</small>
                                                        <input type="checkbox" class="" name="toggle_container_number"
                                                               data-col-index="2" checked>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <small style="font-weight: bold">container no.</small>
                                                        <input type="checkbox" class="" name="toggle_container_number"
                                                               data-col-index="3" checked>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <small style="font-weight: bold">Category.</small>
                                                        <input type="checkbox" class="" name="toggle_yard_location"
                                                               data-col-index="4" checked>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <small style="font-weight: bold">Yard Loc.</small>
                                                        <input type="checkbox" class="" name="toggle_yard_location"
                                                               data-col-index="5" checked>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <small style="font-weight: bold">Set Temp</small>
                                                        <input type="checkbox" class="" name="toggle_set_temp"
                                                               data-col-index="6" checked>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <small style="font-weight: bold">Plug On Date</small>
                                                        <input type="checkbox" class="" name="toggle_plug_on_date"
                                                               data-col-index="7" checked>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <small style="font-weight: bold">Plug On time</small>
                                                        <input type="checkbox" class="" name="toggle_plug_on_time"
                                                               data-col-index="8" checked>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <small style="font-weight: bold">Plug On temp</small>
                                                        <input type="checkbox" class="" name="toggle_plug_on_time"
                                                               data-col-index="9" checked>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <small style="font-weight: bold">Plug Off Date</small>
                                                        <input type="checkbox" class="" name="toggle_plug_off_date"
                                                               data-col-index="10" checked>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <small style="font-weight: bold">Plug Off Time</small>
                                                        <input type="checkbox" class="" name="toggle_plug_off_time"
                                                               data-col-index="11" checked>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <small style="font-weight: bold">Plug Off Temp</small>
                                                        <input type="checkbox" class="" name="toggle_plug_off_temp"
                                                               data-col-index="12" checked>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <small style="font-weight: bold">No Of Days</small>
                                                        <input type="checkbox" class="" name="toggle_no_of_days"
                                                               data-col-index="13" checked>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <small style="font-weight: bold">Loading Vessel</small>
                                                        <input type="checkbox" class="" name="toggle_loading_vessel"
                                                               data-col-index="14" checked>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <small style="font-weight: bold">Loading Voyage</small>
                                                        <input type="checkbox" class="" name="toggle_loading_voyage"
                                                               data-col-index="15" checked>
                                                    </div>
                                                        @show
                                                </div>
                                            </div>
                                            @section('key')
                                            <small style="font-weight: bold; font-size: 9px; color: darkred;">
                                                U/T - Unit Tripping &nbsp;
                                                U/R - Unit Repair &nbsp;
                                                B/W - Bad Weather &nbsp;
                                                W/D - Water Damage &nbsp;
                                                F/D - Fire Damage &nbsp;
                                                D/D - Damaged Door &nbsp;
                                                T/D - Temperature Deviation &nbsp;
                                                OTH - Other &nbsp;
                                                EOFF - Excessive Time Off-Power &nbsp;
                                                CND - Condensation &nbsp;
                                            </small>
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
                                    <tr>
                                        <th></th>
                                        <th>Vessel</th>
                                        <th>Voyage</th>
                                        <th>container no.</th>
                                        <th>category</th>
                                        <th>Yard Loc</th>
                                        <th>Set Temp</th>
                                        <th>Plug on Date</th>
                                        <th>Plug on time</th>
                                        <th>Plug on temp</th>
                                        {{--<th>Temp Unit</th>--}}
                                        {{--<th>Status</th>--}}
                                        {{--<th>Date</th>--}}
                                        {{--<th>04:00</th>--}}
                                        {{--<th>08:00</th>--}}
                                        {{--<th>12:00</th>--}}
                                        {{--<th>16:00</th>--}}
                                        {{--<th>20:00</th>--}}
                                        {{--<th>24:00</th>--}}
                                        {{--<th>on/off Only</th>--}}
                                        <th>Plug off Date</th>
                                        <th>Plug off time</th>
                                        <th>Plug off temp</th>
                                        <th>No Of Days</th>
                                        <th>Loading Vessel</th>
                                        <th>Loading Voyage</th>
                                        {{--<th>Quick Save</th>--}}
                                        {{--<th>Delete</th>--}}
                                        {{--<th>Action</th>--}}
                                    </tr>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Vessel</th>
                                        <th>Voyage</th>
                                        <th>container no.</th>
                                        <th>category</th>
                                        <th>Yard Loc</th>
                                        <th>Set Temp</th>
                                        <th>Plug on Date</th>
                                        <th>Plug on time</th>
                                        <th>Plug on temp</th>
                                        {{--<th>Temp Unit</th>--}}
                                        {{--<th>Status</th>--}}
                                        {{--<th>Date</th>--}}
                                        {{--<th>04:00</th>--}}
                                        {{--<th>08:00</th>--}}
                                        {{--<th>12:00</th>--}}
                                        {{--<th>16:00</th>--}}
                                        {{--<th>20:00</th>--}}
                                        {{--<th>24:00</th>--}}
                                        {{--<th>on/off Only</th>--}}
                                        <th>Plug off Date</th>
                                        <th>Plug off time</th>
                                        <th>Plug off temp</th>
                                        <th>No Of Days</th>
                                        <th>Loading Vessel</th>
                                        <th>Loading Voyage</th>
                                        {{--<th>Quick Save</th>--}}
                                        {{--<th>Delete</th>--}}
                                        {{--<th>Action</th>--}}
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
    {{--todo - save button data attribute check for status and save accordingly--}}
    <script>
        var notification_box_variables = {
            globalPosition: "bottom left",
            autoHideDelay: 5000,
            showDuration: 250,
            hideDuration: 250,
        }

        //triggert all schedule elements
        function schedule_validation_trigger() {
            $.each($('tbody').find('input[name^=schedule_]'), function (k, v) {
                $(v).trigger('change');
            });
        }



        $(document).ready(function () {
            window.row_clone = '';
            //previous schedules need to be filled
            $('tbody').delegate('input[name^=schedule_]', 'focus', function (e) {
                window.row_clone = $(this).closest('tr').clone();//a on focus clone is saved to access previous values of the fields
                //console.log(row_clone);
            });

            $('tbody').delegate('input[name^=schedule_]', 'change', function (e) {
                var table_row = $(this).closest('tr');
                var other_elements = table_row.find('input[name^=schedule_]');
                var errors = 0;
                var berrors = 0;
                var event_target = $(this);
                var this_counter = 0;//count if this element passed the iteration

                // console.log(event_target);

                if (event_target.val() != '') { //only trigger if element has a value.
                    $.each(other_elements, function (k, v) {
                        if ($(v).attr('name') == event_target.attr('name')) {
                            return false;
                        }
                        if (!$(v).attr('readonly') == true && !$(v).attr('disabled') == true && $(v).val() == '') {
                            errors++;
                            $.notify(
                                $(v).attr('name') + " Value Required  !",
                                notification_box_variables
                            );

                        }
                    });
                    if (errors > 0) {
                        event_target.val('');
                    }

                } else if (window.row_clone != '') { //trigger if element and row clone has value
                    console.log(window.row_clone);
                    $.each(other_elements, function (k, v) {
                        if ($(v).attr('name') == event_target.attr('name')) {
                            //return false;
                            this_counter++;
                        }
                        if (this_counter == 1) {
                            this_counter++; //to skip the current element
                        } else if (this_counter == 2 && $(v).val() != '') {
                            berrors++;
                            //console.log($(v).val());
                            $.notify(
                                'To Preform this operation ' + $(v).attr('name') + " Value Should be empty !",
                                notification_box_variables
                            );
                        }
                    });

                    if (berrors > 0) {
                        var previous_val = window.row_clone.find('input[name=' + event_target.attr('name') + ']').val();
                        //console.log(previous_val);
                        event_target.val(previous_val);
                    }
                }
                //set temperature variation validation
                var tr_data = window.table.row(table_row).data();
                var upper_limit = parseFloat(tr_data.set_temp) + 5.0;
                var lover_limit = parseFloat(tr_data.set_temp) - 5.0;
                if (parseFloat(event_target.val()) > upper_limit) {
                    $(event_target).addClass('bg-danger');
                } else if (parseFloat(event_target.val()) < lover_limit) {
                    $(event_target).addClass('bg-danger');
                } else {
                    $(event_target).removeClass('bg-danger');
                }


            });

            //on document load validation
            schedule_validation_trigger();

        });

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
            });
            $('#datetimepicker5').datetimepicker({
                format: 'YYYY-MM-DD',
            });

            $('#datetimepicker3').datetimepicker({
                format: 'HH:mm'
            });
            $('select').selectpicker();
        });
    </script>

    <script>
        //Validations
        //ajaxresonce messages
        function responce_messages(d) {
            d = JSON.parse(d);
            if (d.monitoring) {
                $.notify(
                    'Success: ' +
                    (d.monitoring.container_number || '') +
                    " monitoring_id:" + (d.monitoring.id ? d.monitoring.id || '' : '') +
                    "\n date:" + (d.monitoring.date ? d.monitoring.date || '' : '') +
                    "\n 04:00:" + (d.monitoring.schedule_4 ? d.monitoring.schedule_4 || '' : '') +
                    "\n 08:00:" + (d.monitoring.schedule_8 ? d.monitoring.schedule_8 || '' : '') +
                    "\n 12:00:" + (d.monitoring.schedule_12 ? d.monitoring.schedule_12 || '' : '') +
                    "\n 16:00:" + (d.monitoring.schedule_16 ? d.monitoring.schedule_16 || '' : '') +
                    "\n 20:00:" + (d.monitoring.schedule_20 ? d.monitoring.schedule_20 || '' : '') +
                    "\n 24:00:" + (d.monitoring.schedule_24 ? d.monitoring.schedule_24 || '' : '') +
                    "\n container_id:" + (d.monitoring.container_id ? d.monitoring.container_id || '' : '') +
                    " Temp Unit:" + (d.monitoring.plug_on_date || '') + '....'
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
            }

            if (d.container) {
                $.notify(
                    'Success: ' +
                    (d.container.container_number || '') +
                    "\n Vessel:" + (d.container.vessel ? d.container.vessel.name || '' : '') +
                    " Voyage:" + (d.container.voyage ? d.container.voyage.code || '' : '') +
                    "\n loading_vessel:" + (d.container.loading_vessel ? d.container.loading_vessel.name || '' : '') +
                    " Loading_voyage:" + (d.container.loading_voyage ? d.container.loading_voyage.code || '' : '') +
                    " \n Yard:" + (d.container.yard_location || '') +
                    " Category:" + (d.container.ts_local || '') +
                    " \n Temp Unit:" + (d.container.temperature_unit || '') +
                    " Temp Unit:" + (d.container.plug_on_date || '') + '....'
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
            }


            var data = d.message;
            //console.log(data.error);
            $.each(data, function (q, w) {
                var error_list = '';
                var save_responce_error_count = 0;
                $.each(w, function (k, v) {
                    save_responce_error_count++;
                    error_list += '\n' + v;
                });
                if (save_responce_error_count > 0) {
                    $.notify(
                        q.toUpperCase() + ':' + error_list
                        ,
                        {
                            globalPosition: 'bottom left',
                            autoHideDelay: 15000,
                            showDuration: 250,
                            hideDuration: 250,
                            hideAnimation: 'slideUp',
                            style: 'bootstrap',
                            className: q,
                        }
                    );
                }

            });
        }

        //check if all schedules are empty or data is in invalid format before quic save/create
        function isSchedulesNotEmpty(data) {
            var fill_string = '';
            $.each($('<div></div>').html(data).find('input[name^=schedule_]'), function (k, v) {
                if (!$(v).attr('disabled') == true && !$(v).attr('readonly') == true) {
                    if ($(v).val() == '') {
                        fill_string += 'e';
                    } else {
                        fill_string += 'f';
                    }
                }
            });
            if (fill_string == '') return true;
            //console.log(fill_string);
            return /^(?![e*])f*e*\b/.test(fill_string);
        }

        $(document).ready(function () {


            //save edited changes
            $('div[name=edit_box] button[name=save_changes]').click(function () {
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
            });

            //revert previous changes
            $('div[name=edit_box] button[name=revert_changes]').click(function () {
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
            });

            //Delete Selection changes
            $('div[name=edit_box] button[name=delete_selection]').click(function () {
                var data = $('div[name=edit_box]').find('input,select').add($('div[name=search_box]').find('input,select'));
                if (confirm('Do you want to DELETE ? After deletion data !! CAN NOT !! be recovered !')) {
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
            });

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

            //plug off column toggle
            // $('input[name=toggl_plug_off]').on('click', function (e) {
            //     // Get the column API object
            //     var column_16 = table.column(16);
            //     var column_17 = table.column(17);
            //     var column_18 = table.column(18);
            //     var column_19 = table.column(19);
            //
            //     // Toggle the visibility
            //     if ($(this).is(':checked')) {
            //         column_16.visible(true);
            //         column_17.visible(true);
            //         column_18.visible(true);
            //         /*column_19.visible(true);*/
            //         table.ajax.reload(null, false);//reload table without changing user paging
            //     } else {
            //         column_16.visible(false);
            //         column_17.visible(false);
            //         column_18.visible(false);
            //         /*column_19.visible(false);*/
            //     }
            // });

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
                // rowReorder: {
                //     selector: 'td:nth-child(2)'
                // },
                dom: /*"<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>"*/
                    "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-6'i><'col-sm-6'p>>"+
                    "<'row'<'col-sm-12'tr>>",
                pageLength: 25,
                "lengthMenu": [[10, 25, 50,100,500,1000], [10, 25, 50,100,500,1000]],
                responsive: true,
                buttons: [{
                    extend: 'print',
                    autoPrint: false,
                    messageTop: function () {
                        return '<div class="row">' +
                            '<div class="col-md-12">' +
                            '<span style="font-size: 25px; font-weight: bold ">' +
                            'Monitoring Report' +
                            '</span>' +
                            '</div></div>' +
                            '<div class="row"><div class="col-md-3">Plug On From:</div> ' +
                            '<div class="col-md-3">'+$('input[name=date_from]').val()+'</div> ' +
                            '<div class="col-md-3">Plug On To:</div> ' +
                            '<div class="col-md-3">'+$('input[name=date_to]').val()+'</div> ' +
                            '<div class="col-md-3">Vessel:</div> ' +
                            '<div class="col-md-3">'+$('select[name=vessel_id] option:selected').html()+'</div> ' +
                            '<div class="col-md-3">Voyage:</div> ' +
                            '<div class="col-md-3">'+$('select[name=voyage_id] option:selected').html()+'</div> ' +
                            // '<div class="col-md-12"><strong> <small>U/T - Unit Tripping   U/R - Unit Repair   B/W - Bad Weather   W/D - Water Damage   F/D - Fire Damage   D/D - Damaged Door   T/D - Temperature Deviation   OTH - Other   EOFF - Excessive Time Off-Power   CND - Condensation</small></strong> </div>' +
                            '</div>';

                    },
                    exportOptions: {
                        columns: ':visible'
                    },
                    messageBottom: null
                }/*,
                    'colvis'*/],
                // responsive: {
                //     details: {
                //         display: $.fn.dataTable.Responsive.display.childRowImmediate,
                //         type: 'none',
                //         target: ''
                //     }
                // },
                @section('dt_col')
                "columnDefs": [
                    // {"visible": false, "targets": 16},
                    // {"visible": false, "targets": 17},
                    // {"visible": false, "targets": 18},
                    // {"visible": false, "targets": 19},
                    // {"visible": false, "targets": 6},
                    // {"visible": false, "targets": 8},
                    // {"visible": false, "targets": 9},
                    // {"visible": false, "targets": 20}
                    {"targets": 6, "className": 'dt-right'}
                ],
                columns: [
                    {data: 'empty', orderable: false},
                    {data: 'vessel_name'},
                    {data: 'voyage_code'},
                    {data: 'container_number'},
                    {data: 'ts_local'},
                    {data: 'yard_location'},
                    {data: 'set_temp', orderable: false},
                    {data: 'plug_on_date'},
                    {data: 'plug_on_time', orderable: false},
                    {data: 'plug_on_temp', orderable: false,"className": 'dt-right'},
                    // {data: 'temperature_unit', orderable: false},
                    // {data: 'state', orderable: false},
                    // {data: 'monitoring_date', orderable: false},
                    // {data: 'schedule_4', orderable: false},
                    // {data: 'schedule_8', orderable: false},
                    // {data: 'schedule_12', orderable: false},
                    // {data: 'schedule_16', orderable: false},
                    // {data: 'schedule_20', orderable: false},
                    // {data: 'schedule_24', orderable: false},
                    //{data: 'plugging_category',orderable: false, searchable: false,},
                    {data: 'plug_off_date'},
                    {data: 'plug_off_time', orderable: false},
                    {data: 'plug_off_temp', orderable: false,"className": 'dt-right'},
                    {data: 'no_of_days', orderable: false},
                    {data: 'loading_vessel_name', orderable: false},
                    {data: 'loading_voyage_code', orderable: false},

                    // {data: 'quick_save', orderable: false, searchable: false, all: true},
                    // {data: 'delete', orderable: false, searchable: false, all: true},
                    // {data: 'action', orderable: false, searchable: false, all: true}
                ],
                @show
                "ajax": {
                    "url": '{{url('data/monitoring_report')}}',
                    "type": 'POST',
                    "data": function (d) {
                        d.extra_search = $('div[name=search_box]').find("input,select").serialize() + '&file_id=@yield('file_id')';//additional search parameters from search boxes
                    },
                },

            }).on('init.dt draw', function () {
                window.row_clone = ''; //
                //console.log( 'Table initialisation complete: '+new Date().getTime() );
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
                $('#containerTable').find('input[name^=schedule_]').each(function (k, v) {
                    $(v).change(function (e) {
                        var v = tempFormat($(this).val());
                        //console.log(v);
                        $(this).val(v === false ? '' : v);
                    });
                });

                //time format correction
                $('tbody').find('input[name=plug_off_time]').each(function (k, v) {
                    $(v).change(function (e) {
                        $(this).val(timeFormat($(this).val()) == false ? '' : timeFormat($(this).val()));
                    });
                });
                //if toggl on load date with default value
                $('tbody').find('input[name=plug_off_date]').each(function(k,v){

                    if($('input[name=toggl_plug_off]').is(':checked')){
                        if($(v).data('status')==0){
                            //if plug off date stays the same
                        }else{
                            $(v).val($('input[name=date]').val());
                        }
                    }else{
                        $(v).val('');
                    }
                });

                //validate schedules on data load
                schedule_validation_trigger();
            })
                //arrow key tab function
                .on( 'key-focus', function ( e, datatable, cell, originalEvent ) {
                $(cell.node()).find('input,button').focus();
            });
            window.table = table;
///on plug on of only button toggle.
            $('#containerTable').delegate('input[name=plugging_category]','click',function (e) {
               var cont_id = $(this).data('container');
               console.log(cont_id);
               $.ajax({
                   method:'POST',
                   url:'{{url('/plugging_category/')}}'+'/'+cont_id,
                   data:$(this).serialize()
               }).done(function (d) {
                    if(d.reefer_monitoring.length<1) {
                        $.notify(
                            "Container changed to " + d.plugging_category,
                            {
                                globalPosition: "bottom left",
                                autoHideDelay: 5000,
                                showDuration: 250,
                                hideDuration: 250,
                                style: 'bootstrap',
                                className: 'success'
                            }
                        );
                    }else{
                        $.notify(
                            "Container Has monitoring action is forbidden",
                            {
                                globalPosition: "bottom left",
                                autoHideDelay: 5000,
                                showDuration: 250,
                                hideDuration: 250,
                                style: 'bootstrap',
                                className: 'error'
                            }
                        );
                    }

               }).always(function () {
                   table.ajax.reload(null, false);//reload table without changing user paging
               });
            });

            function quic_save_validation(tr) {
                var elem = [];
                var notification_box_variables = {
                    globalPosition: "bottom left",
                    autoHideDelay: 5000,
                    showDuration: 250,
                    hideDuration: 250,
                }
                var error_count = 0;
                $.each(tr.find('input'), function (k, v) {
                    elem[$(v).attr('name')] = $(v);
                })
                //plug on date
                if (!isValidDate(typeof elem['plug_off_date'] !== 'undefined' ? elem['plug_off_date'].val() : '', {empty: true})) {
                    error_count++;
                    $.notify(
                        "Plug Off Date format not valid",
                        notification_box_variables
                    );
                }

                //plug off time
                if (!isValidTime(typeof elem['plug_off_time'] !== 'undefined' ? elem['plug_off_time'].val() : '')) {
                    error_count++;
                    $.notify(
                        "Plug off Time format not valid",
                        notification_box_variables
                    );
                }
                var status = tr.find('#quick_save').data('status');
                if($('input[name=toggl_plug_off]').is(':checked')&& status!=0){
                    if(elem['plug_off_date'].val()==''
                        ||elem['plug_off_time'].val()==''
                        ||elem['plug_off_temp'].val()==''){
                        error_count++;
                        $.notify(
                            "Plug off date time and temp must be filled.",
                            notification_box_variables
                        );

                    }
                }


                return !(error_count > 0);
            }

            //on quick save button click
            $('#containerTable').delegate('#quick_save', 'click', function (e) {
                //e.preventDefault();
                var this_button = $(this);
                var table_row = $(this).closest('tr');
                var form = $('#search_form');

                var plug_off_date = table_row.find('input[name=plug_off_date]');
                var plug_off_time = table_row.find('input[name=plug_off_time]');
                var plug_off_temp = table_row.find('input[name=plug_off_temp]');
                //console.log(plug_off_date, plug_off_time, plug_off_temp);
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
                    tr_clone.add('@csrf');
                    data = tr_clone.find('input,select');

                    tr_clone.remove();
                }
                //console.log($('div[name="search_box"]').find('input,select'));


                var valid =isSchedulesNotEmpty(data)
                if(typeof plug_off_date.val() != 'undefined'
                    &&typeof plug_off_time.val() != 'undefined'
                    &&typeof plug_off_temp.val() != 'undefined'
                    &&plug_off_date.val() != ''
                    && plug_off_time.val() != ''
                    && plug_off_temp.val() != ''){
                    valid = true;
                }

                //if (valid) { //commented for new update
                    //data is posted to update
                    var url = '{{url('monitoring_row_update')}}/' +
                        this_button.data('id') +
                        (this_button.data('monitoring-id') === '' ? '/' + this_button.data('status') == 0 ? '/poffe' : '/poff' : '/' + this_button.data('monitoring-id'));

                    //console.log(url,this_button.data('monitoring-id'));


///validations//


                    if (quic_save_validation(table_row)) {
                        $.ajax({
                            method: "POST",
                            url: url,
                            data: data.serialize() + '&' + $('div[name="search_box"]').find('input,select').serialize()+'&status=' + this_button.data('status')
                        }).done(function (d) {
                            responce_messages(d)
                            //alert('Container:' + d.container_number + " updated vessel voyage applyied");
                        }).fail(function (d) {//on update fail
                            window.alert(JSON.stringify(d));//error alert to user
                        }).always(function (jqXHR) { //under any condition
                            table.ajax.reload(null, false);//reload table without changing user paging
                        });
                    }
                // } else {//commented for new update
                //     $.notify(
                //         "Cannot save Temperatures are filled in invalid manner or all are empty!",
                //         notification_box_variables
                //     );
                // }


            });

            //on quick create button click
            $('#containerTable').delegate('#create', 'click', function (e) {
                //e.preventDefault();
                var this_button = $(this);
                var table_row = $(this).closest('tr');
                var form = $('#search_form');

                var plug_off_date = table_row.find('input[name=plug_off_date]');
                var plug_off_time = table_row.find('input[name=plug_off_time]');
                var plug_off_temp = table_row.find('input[name=plug_off_temp]');

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
                //console.log($('div[name="search_box"]').find('input,select'));
                console.log(plug_off_date.val()
                    && plug_off_time.val()
                    && plug_off_temp.val() )
                var valid =isSchedulesNotEmpty(data)
                if(typeof plug_off_date.val() != 'undefined'
                    &&typeof plug_off_time.val() != 'undefined'
                    &&typeof plug_off_temp.val() != 'undefined'
                    &&plug_off_date.val() != ''
                    && plug_off_time.val() != ''
                    && plug_off_temp.val() != ''){
                    valid = true;
                }

                //if (valid ) {
                    if (quic_save_validation(table_row)) {

                        //data is posted to update
                        $.ajax({
                            method: 'post',
                            url: '{{url('monitoring_row_create')}}/' + this_button.data('id'),
                            data: data.serialize() + '&' + $('div[name="search_box"]').find('input,select').serialize() + '&status=' + this_button.data('status')
                        }).done(function (d) {
                            responce_messages(d);
                            //alert('Container:' + d.container_number + " updated vessel voyage applyied");
                        }).fail(function (d) {//on update fail
                            window.alert(JSON.stringify(d));//error alert to user
                        }).always(function (jqXHR) { //under any condition
                            table.ajax.reload(null, false);//reload table without changing user paging
                        });
                    }

                // } else {
                //     $.notify(
                //         "Cannot save Temperatures are filled in invalid manner or all are empty!",
                //         notification_box_variables
                //     );
                // }


            });


            //delete
            $('#containerTable').delegate('#delete', 'click', function (e) {
                e.preventDefault();
                var form = $(this).closest('form');
                var id = $(this).data('id');
                $.ajax({
                    method: 'POST',
                    url: '{{url('monitoring_row_delete/')}}' + '/' + id,
                    data: form.serialize()
                }).done(function (d) {
                    responce_messages(d);
                }).fail(function (d) {//on update fail
                    window.alert(JSON.stringify(d));//error alert to user
                }).always(function (d) {
                    table.ajax.reload(null, false);//reload table without changing user paging
                })
            });

            $('#containerTable').delegate('input[name=plug_off_date]', 'click', function (e){
                if($(this).val()=='') {
                    $(this).val($('input[name=date]').val());
                }
            });

        });

    </script>
@endsection
