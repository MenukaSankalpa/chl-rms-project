@extends('layout.app')
@section('content')
    <a href="{{url('/reefer_monitoring')}}" class=""><i class="fa fa-arrow-alt-circle-left"></i> Go Back </a>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Reefer Monitoring Upload/Edit</h1>

    <div class="row">
        @include('reefer_monitoring.contents.modal')
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12" name="search_form">
                                <div class="row">

                                    <div class="col-md-4 ">

                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>Vessel</label>
                                            </div>
                                            <div class="col-md-6">
                                                <select name="vessel_id" class="form-control form-control-sm" data-live-search="true"
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
                                                <label>Container Number</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control form-control-sm" name="container_number"
                                                       placeholder="Container Number"
                                                       maxlength="11"
                                                       required>
                                            </div>
                                        </div>
                                    </div>

                                        <div class="col-md-4 ">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label>Voyage</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="voyage_id" class="form-control form-control-sm" data-live-search="true"
                                                            tabindex="2">
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label>Yard Location</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control form-control-sm" name="yard_location"
                                                           placeholder="Yard Location"
                                                           maxlength="10"
                                                           required>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-4 ">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label>Box Owner</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="box_owner" class="form-control form-control-sm" data-live-search="true"
                                                            tabindex="16">
                                                        <option value="">[SELECT]</option>
                                                        <option value="ALL_OWNERS">[ALL]</option>
                                                        @foreach($box_owners as $box_owner)
                                                            <option value="{{$box_owner->id}}">{{$box_owner->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label>Loading/Discharging</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="loading_discharging" class="form-control form-control-sm"
                                                            data-live-search="true" tabindex="4">
                                                        <option value="B">[Both]</option>
                                                        <option value="L">Loading</option>
                                                        <option value="D">Discharging</option>
                                                    </select>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-md-12">
                                            <button class="btn btn-primary btn-sm{{--float-right--}} " id="search"
                                                    name="search"><i
                                                    class="fa fa-search"></i> Search
                                            </button>
                                            {{--                                        <span class="float-right">
                                                                                        <a class="btn btn-success btn-sm" data-toggle="modal"
                                                                                           data-target="#myModal"><i
                                                                                                    class="fa fa-upload"></i>Upload</a>
                                                                                    </span>--}}

                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="card shadow mb-4 mt-2">
                                        <div class="card-header py-3">
                                            <span class="float-left col-md-9">
                                                <div class="form-group  row">
                                                    {{--<div class="col-md-12">--}}
                                                    {{--<label class="d-inline">Search:</label>--}}
                                                    {{--</div>--}}
                                                    <div class="col-md-12">
                                                    <input type="text"
                                                           class="form-control form-control-sm d-inline"
                                                           name="search_container"
                                                           placeholder="Search Container number:"
                                                           required>
                                                    </div>
                                                </div>
                                                </span>
                                        </div>
                                        <div class="card-body">
                                            <ul name="containers" class="list-group" style=" overflow-y: scroll;">

                                            </ul>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-9 mt-2" name="monitoring_data">
                                    <div class="col-md-12">

                                        <div class="card shadow mb-4">
                                            <!-- Card Content - Collapse -->
                                            <div class="" id="">
                                                <div class="card-body">
                                                    <div class="row" name="plug_on_off">
                                                        {{--Plug On--}}
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Plug On Date</label>
                                                                        <div class="input-group date"
                                                                             id="datetimepicker5"
                                                                             data-target-input="nearest">
                                                                            <input type="text" name="plug_on_date"
                                                                                   class="form-control form-control-sm datetimepicker-input"
                                                                                   data-target="#datetimepicker5"
                                                                                   tabindex="9"/>
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
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Plug On Time</label>
                                                                        <div class="input-group date"
                                                                             id="datetimepicker3"
                                                                             data-target-input="nearest">
                                                                            <input type="text" name="plug_on_time"
                                                                                   class="form-control form-control-sm datetimepicker-input"
                                                                                   data-target="#datetimepicker3"
                                                                                   tabindex="10"/>
                                                                            <div class="input-group-append"
                                                                                 data-target="#datetimepicker3"
                                                                                 data-toggle="datetimepicker">
                                                                                <div class="input-group-text"><i
                                                                                        class="fa fa-clock"></i></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Plug On Temp</label>
                                                                        <input type="number" step="0.00"
                                                                               class="form-control form-control-sm"
                                                                               name="plug_on_temp"
                                                                               placeholder="Plug on Temp"
                                                                               maxlength="10"
                                                                               required>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        {{--End Plug On--}}
                                                        {{--Plug off--}}
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Plug off Date</label>
                                                                        <div class="input-group date"
                                                                             id="datetimepicker6"
                                                                             data-target-input="nearest">
                                                                            <input type="text" name="plug_off_date"
                                                                                   class="form-control form-control-sm datetimepicker-input"
                                                                                   data-target="#datetimepicker6"
                                                                                   tabindex="9"/>
                                                                            <div class="input-group-append"
                                                                                 data-target="#datetimepicker6"
                                                                                 data-toggle="datetimepicker">
                                                                                <div class="input-group-text"><i
                                                                                        class="fa fa-calendar"></i>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Plug Off Time</label>
                                                                        <div class="input-group date"
                                                                             id="datetimepicker7"
                                                                             data-target-input="nearest">
                                                                            <input type="text" name="plug_off_time"
                                                                                   class="form-control form-control-sm datetimepicker-input"
                                                                                   data-target="#datetimepicker7"
                                                                                   tabindex="10"/>
                                                                            <div class="input-group-append"
                                                                                 data-target="#datetimepicker7"
                                                                                 data-toggle="datetimepicker">
                                                                                <div class="input-group-text"><i
                                                                                        class="fa fa-clock"></i></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Plug Off Temp</label>
                                                                        <input type="number" step="0.00"
                                                                               class="form-control form-control-sm"
                                                                               name="plug_off_temp"
                                                                               placeholder="Plug off temp"
                                                                               maxlength="10"
                                                                               required>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        {{--End plug off--}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="card shadow mb-4">
                                            <form name="monitoring_schedule">
                                                <div class="card-header py-3">
                                                    <h6 class="m-0 font-weight-bold text-primary">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Monitor Date</label>
                                                                <div class="input-group date" id="datetimepicker4"
                                                                     data-target-input="nearest">
                                                                    <input type="text" name="date"
                                                                           class="form-control form-control-sm datetimepicker-input"
                                                                           data-target="#datetimepicker4" tabindex="9"
                                                                           required/>
                                                                    <div class="input-group-append"
                                                                         data-target="#datetimepicker4"
                                                                         data-toggle="datetimepicker">
                                                                        <div class="input-group-text"><i
                                                                                class="fa fa-calendar"></i></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-group ">
                                                                    <button
                                                                        class="btn btn-success  mt-4{{--float-right--}} "
                                                                        id="new"
                                                                        name="new"><i
                                                                            class="fa fa-plus-circle "></i> Add
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            {{--@method('put')--}}
                                                            @csrf
                                                            <div class="form-group">
                                                                <label>04:00</label>
                                                                <input type="number" step="0.00" class="form-control form-control-sm"
                                                                       name="schedule_4"
                                                                       placeholder="04:00 Temp"
                                                                >
                                                            </div>
                                                            <div class="form-group">
                                                                <label>16:00</label>
                                                                <input type="number" step="0.00" class="form-control form-control-sm"
                                                                       name="schedule_16"
                                                                       placeholder="16:00 Temp"
                                                                >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>08:00</label>
                                                                <input type="number" step="0.00" class="form-control form-control-sm"
                                                                       name="schedule_8"
                                                                       placeholder="08:00 Temp"
                                                                >
                                                            </div>
                                                            <div class="form-group">
                                                                <label>20:00</label>
                                                                <input type="number" step="0.00" class="form-control form-control-sm"
                                                                       name="schedule_20"
                                                                       placeholder="20:00 Temp"
                                                                >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>12:00</label>
                                                                <input type="number" step="0.00" class="form-control form-control-sm"
                                                                       name="schedule_12"
                                                                       placeholder="12:00 Temp"
                                                                >
                                                            </div>
                                                            <div class="form-group">
                                                                <label>24:00</label>
                                                                <input type="number" step="0.00" class="form-control form-control-sm"
                                                                       name="schedule_24"
                                                                       placeholder="24:00 Temp"
                                                                >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="col-md-12" name="past_days">

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection
        @section('script')
            {{--Main global variables--}}
            <script>
                //schedule template element
                var template_schedule = $($.ajax({
                    url: '{{url('/monitoring_schedule')}}',
                    method: 'GET',
                    async: false
                }).responseText);
                //var schedule2 = $('').load('{{url('/monitoring_schedule')}}');
                //console.log($(schedule));

                //search function
                function search() {
                    var data = $('div[name=search_form]').find('select,input').serialize();
                    $.ajax({
                        method: 'POST',
                        url: '{{url('data/containers_search')}}',
                        data: data
                    }).done(function (d) {

                        window.selectedContainer = '';

                        $('ul[name=containers]').empty();
                        var container_template = $('@include('reefer_monitoring.contents.container')');
                        $.each(d, function ($k, $v) {
                            var container = container_template.clone();
                            container.html($v.container_number + ' :' + $v.loading_discharging);
                            container.data($v);
                            $('ul[name=containers]').append(container);
                        });
                    });

                    $('div[name=monitoring_data]').hide();
                }

                //end of search function

                function fill_monitoring_data(c_info, template) {
                    //data fill plug on and off
                    $('div[name=plug_on_off]').find('input[name=plug_on_date]').val(c_info.plug_on_date);
                    $('div[name=plug_on_off]').find('input[name=plug_on_time]').val(c_info.plug_on_time);
                    $('div[name=plug_on_off]').find('input[name=plug_on_temp]').val(c_info.plug_on_temp);

                    $('div[name=plug_on_off]').find('input[name=plug_off_date]').val(c_info.plug_off_date);
                    $('div[name=plug_on_off]').find('input[name=plug_off_time]').val(c_info.plug_off_time);
                    $('div[name=plug_on_off]').find('input[name=plug_off_temp]').val(c_info.plug_off_temp);

                    $('div[name=past_days]').empty();

                    if (c_info.reefer_monitoring.length != 0) {

                        $.each(c_info.reefer_monitoring, function (k, v) {
                            var schedule = template.clone();

                            // schedule.find('a').attr('href','collaps'+c_info.id);
                            // schedule.find('a').attr('aria-controls','collaps'+c_info.id);
                            // schedule.find('div[name=collapseCardExample').attr('id','collaps'+c_info.id);
                            //     console.log($(v));
                            schedule.find('form').data(v);
                            schedule.find('h6').html(v.date);
                            schedule.find('input[name=schedule_4]').val(v.schedule_4);
                            schedule.find('input[name=schedule_8]').val(v.schedule_8);
                            schedule.find('input[name=schedule_12]').val(v.schedule_12);
                            schedule.find('input[name=schedule_16]').val(v.schedule_16);
                            schedule.find('input[name=schedule_20]').val(v.schedule_20);
                            schedule.find('input[name=schedule_24]').val(v.schedule_24);
                            //
                            $('div[name=past_days]').append(schedule);
                        });
                    }
                }

                function clear_monitoring_data() {
                    //data fill plug on and off
                    $('div[name=plug_on_off]').find('input[name=plug_on_date]').val('');
                    $('div[name=plug_on_off]').find('input[name=plug_on_time]').val('');
                    $('div[name=plug_on_off]').find('input[name=plug_on_temp]').val('');

                    $('div[name=plug_on_off]').find('input[name=plug_off_date]').val('');
                    $('div[name=plug_on_off]').find('input[name=plug_off_time]').val('');
                    $('div[name=plug_on_off]').find('input[name=plug_off_temp]').val('');

                    $('div[name=past_days]').empty();
                    $('form[name=monitoring_schedule]').find('input[name=date]').val('');
                    $('form[name=monitoring_schedule]').find('input[name=schedule_4]').val('');
                    $('form[name=monitoring_schedule]').find('input[name=schedule_8]').val('');
                    $('form[name=monitoring_schedule]').find('input[name=schedule_12]').val('');
                    $('form[name=monitoring_schedule]').find('input[name=schedule_16]').val('');
                    $('form[name=monitoring_schedule]').find('input[name=schedule_20]').val('');
                    $('form[name=monitoring_schedule]').find('input[name=schedule_24]').val('');

                }

                function find_and_update_li(data) {
                    //li element needs to be updated each time ajaxs response
                    // is given to save/update request
                    var containers = $('ul[name=containers]').find('li');

                    $.each(containers, function (k, v) {
                        if ($(v).data().id == data.id) {
                            $(v).data(data);
                        }

                    });
                }
            </script>
            {{--Search and stuff--}}
            <script>
                $(document).ready(function () {

                    window.selectedContainer = '';


                    //search data on page load
                    search();

                    $('button[name=search]').click(function (e) {
                        e.preventDefault();
                        //console.log($('div[name=search_form]').find('select,input'));
                        //search on search button click
                        search();
                    });

                    //tiny search box
                    $('input[name=search_container]').keyup(function () {
                        var val = $(this).val().toUpperCase();
                        var containers = $('ul[name=containers]').find('li');

                        $.each(containers, function (k, v) {
                            if ($(v).text().toUpperCase().indexOf(val) > -1) {
                                $(v).removeClass('d-none');
                            } else {
                                $(v).addClass('d-none');
                            }
                        });

                    });

                    //on container select
                    $('ul[name=containers]').delegate('li', 'click', function () {
                        $(this).addClass('active');//add highlite to selected li
                        var this_s = $(this);
                        var containers = $('ul[name=containers]').find('li');
                        var c_info = window.selectedContainer = this_s.data();
                        $.each(containers, function (k, v) {
                            if ($(v).data() != this_s.data()) {
                                $(v).removeClass('active');//remove highlite from other li's
                            }
                        });
                        clear_monitoring_data();
                        fill_monitoring_data(c_info, template_schedule);
                        //console.log(window.selectedContainer);
                        $('div[name=monitoring_data]').show();
                    });
                });
            </script>
            {{--Data save functions--}}
            <script>
                //container schedule save
                $(document).ready(function () {
                    $('form[name=monitoring_schedule]').submit(function (e) {
                        e.preventDefault();
                        var form = $(this).clone();
                        var container = window.selectedContainer;
                        var data = form.serialize() + '&container_id=' + container.id;
                        //console.log(data);
                        $.ajax({
                            method: 'post',
                            url: '{{url('/reefer_monitoring')}}',
                            data: data,
                            success: function (d) {
                                clear_monitoring_data();
                                fill_monitoring_data(d, template_schedule);
                                find_and_update_li(d);
                            }
                        })
                    });

                    //container schedule update

                    $('div[name=past_days]').delegate('button[name=update]', 'click', function (e) {
                        e.preventDefault();
                        var form = $(this).closest('form');
                        var v = form.data();
                        var data = form.serialize();
                        $.ajax({
                            method: 'post',
                            url: '{{url('/reefer_monitoring/')}}/' + v.id,
                            data: data + '&date=' + v.date,
                            success: function (d) {
                                //clear_monitoring_data();
                                //fill_monitoring_data(d,template_schedule);
                                find_and_update_li(d);
                            }
                        });
                        //console.log(v);
                    })

                    //todo - container schedule delete
                    $('div[name=past_days]').delegate('button[name=delete]', 'click', function (e) {
                        e.preventDefault();
                        var csrf = $('@csrf');
                        var method = $('@method('DELETE')');
                        var form = $(this).closest('form');
                        var v = form.data();
                        csrf.add(method);
                        if (confirm('Are you sure you want to delete ?')) {
                            $.ajax({
                                method: 'post',
                                url: '{{url('/reefer_monitoring/')}}/' + v.id,
                                data: csrf.add(method).serialize(),
                                success: function (d) {
                                    clear_monitoring_data();
                                    fill_monitoring_data(d, template_schedule);
                                    find_and_update_li(d);
                                }
                            });
                        }
                    });

                    //todo - validations
                });
            </script>
            {{--Other ui elements--}}
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


                    $('#datetimepicker4').datetimepicker({
                        format: 'YYYY-MM-DD',
                    });

                    $('#datetimepicker5').datetimepicker({
                        format: 'YYYY-MM-DD',
                    });

                    $('#datetimepicker3').datetimepicker({
                        format: 'HH:mm'
                    });
                    $('#datetimepicker6').datetimepicker({
                        format: 'YYYY-MM-DD',
                    });

                    $('#datetimepicker7').datetimepicker({
                        format: 'HH:mm'
                    });
                    $('select').selectpicker();
                })
            </script>
@endsection
