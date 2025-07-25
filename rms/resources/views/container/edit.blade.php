@extends('layout.app')
@section('content')
    <a href="{{url('/container')}}" class=""><i class="fa fa-arrow-alt-circle-left"></i> Go Back </a>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Container</h1>

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

            <div class="card shadow mb-4">
                <div class="card-body">
                    <form name="edit_form" action="{{url('/container/'.$container->id)}}" method="POST"
                          enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="col-md-12">
                                @csrf
                                @method('put')
                                <div class="row border-bottom">
                                    <div class="col-md-12" style="color: red; font-size: x-small"
                                         name="validation_box"></div>

                                    <div class="col-md-3">

                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>Vessel</label>
                                            </div>
                                            <div class="col-md-6">
                                                <select name="vessel_id" class="form-control form-control-sm"
                                                        data-live-search="true" tabindex="1">
                                                    <option value=''>[SELECT]</option>
                                                    @foreach($vessels as $vessel)
                                                        <option
                                                            value="{{$vessel->id}}" {{$container->vessel_id == $vessel->id ? 'selected':''}}>{{$vessel->name}}</option>
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
                                                    <option
                                                        value="L" {{$container->loading_discharging == "L" ? 'selected':''}}>
                                                        Loading
                                                    </option>
                                                    <option
                                                        value="D" {{$container->loading_discharging == "D" ? 'selected':''}}>
                                                        Discharging
                                                    </option>
                                                </select>
                                            </div>


                                        </div>

                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>Voyage</label>
                                            </div>
                                            <div class="col-md-6">
                                                <select name="voyage_id" class="form-control form-control-sm"
                                                        data-live-search="true" tabindex="2" required>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>Yard Location</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input value="{{$container->yard_location}}" type="text"
                                                       name="yard_location" class="form-control form-control-sm"
                                                       tabindex="5" required>

                                            </div>


                                        </div>

                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>Container Number</label>
                                            </div>

                                            <div class="col-md-6">
                                                <input value="{{$container->container_number}}" type="text"
                                                       class="form-control form-control-sm" name="container_number"
                                                       id="container_number"
                                                       placeholder="Container Number"
                                                       maxlength="11"
                                                       tabindex="3"
                                                       required>
                                            </div>


                                        </div>
                                    </div>

                                </div>

                                <div class="row border-bottom mt-1">
                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>Category</label>
                                            </div>
                                            <div class="col-md-6">
                                                <select name="ts_local" class="form-control form-control-sm"
                                                        data-live-search="true" tabindex="6">
                                                    <option value="TS" {{$container->ts_local == "TS" ? 'selected':''}}>
                                                        Transhipment
                                                    </option>
                                                    <option
                                                        value="IMP" {{$container->ts_local == "IMP" ? 'selected':''}}>
                                                        Import
                                                    </option>
                                                    <option
                                                        value="EXP" {{$container->ts_local == "EXP" ? 'selected':''}}>
                                                        Export
                                                    </option>
                                                    <option value="RSTW" {{$container->ts_local == "RSTW" ? 'selected':''}}>Restow</option>
                                                </select>
                                            </div>


                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>Plug On Time</label>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="input-group date" id="datetimepicker3"
                                                     data-target-input="nearest">
                                                    <input value="{{$container->plug_on_time}}" type="text"
                                                           name="plug_on_time"
                                                           class="form-control form-control-sm datetimepicker-input"
                                                           data-target="#datetimepicker3" tabindex="10" required/>
                                                    <div class="input-group-append" data-target="#datetimepicker3"
                                                         data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-clock"></i></div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>Temperature Unit</label>
                                            </div>

                                            <div class="col-md-6">
                                                <select name="temperature_unit" class="form-control form-control-sm"
                                                        data-live-search="true" tabindex="6">
                                                    <option
                                                        value="C" {{$container->temperature_unit == "C" ? 'SELECTED':''}}>
                                                        Celsius (&#176;C)
                                                    </option>
                                                    <option
                                                        value="F" {{$container->temperature_unit == "F" ? 'SELECTED':''}}>
                                                        Fahrenheit (&#176;F)
                                                    </option>
                                                </select>
                                            </div>


                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>Plug On Temp</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input value="{{$container->plug_on_temp}}" type="number"
                                                       class="form-control form-control-sm" name="plug_on_temp"
                                                       id="plug_on_temp"
                                                       placeholder="Plug on Temp"
                                                       step="0.001"
                                                       tabindex="11"
                                                       required
                                                >
                                            </div>


                                        </div>

                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>Set Temp</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input value="{{$container->set_temp}}" type="number"
                                                       class="form-control form-control-sm" name="set_temp"
                                                       id="set_temp"
                                                       placeholder="Set Temp"
                                                       step="0.001"
                                                       tabindex="8"
                                                       required >
                                            </div>


                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>RDT Temp</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input value="{{$container->rdt_temp}}" type="number"
                                                       class="form-control form-control-sm" name="rdt_temp"
                                                       id="rdt_temp"
                                                       placeholder="RDT Temp"
                                                       step="0.001"
                                                       tabindex="12">
                                            </div>


                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>Plug On Date</label>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group date" id="datetimepicker4"
                                                     data-target-input="nearest">
                                                    <input value="{{$container->plug_on_date}}" type="text"
                                                           name="plug_on_date"
                                                           class="form-control form-control-sm datetimepicker-input"
                                                           data-target="#datetimepicker4" tabindex="9" required/>
                                                    <div class="input-group-append" data-target="#datetimepicker4"
                                                         data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>Remarks</label>
                                            </div>

                                            <div class="col-md-6">
                                                <textarea name="remarks" class="form-control form-control-sm"
                                                          placeholder="Remarks"
                                                          tabindex="13">{{$container->remarks}}</textarea>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-1">
                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>Ex On Carrier Vessel</label>
                                            </div>
                                            <div class="col-md-6">
                                                <select name="ex_on_carrier_vessel" class="form-control form-control-sm"
                                                        data-live-search="true" tabindex="14">
                                                    <option value="">[SELECT]</option>
                                                    @foreach($vessels as $vessel)
                                                        <option
                                                            value="{{$vessel->id}}" {{$container->ex_on_carrier_vessel == $vessel->id ?'selected':'' }}>{{$vessel->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>Ex On Carrier Voyage</label>
                                            </div>
                                            <div class="col-md-6">
                                                <select name="ex_on_carrier_voyage" class="form-control form-control-sm"
                                                        data-live-search="true" tabindex="15">
                                                </select>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>Box Owner</label>
                                            </div>
                                            <div class="col-md-6">
                                                <select name="box_owner" class="form-control form-control-sm"
                                                        data-live-search="true" tabindex="16" >
                                                    <option value="">[SELECT]</option>
                                                    @foreach($box_owners as $box_owner)
                                                        <option
                                                            value="{{$box_owner->id}}" {{$container->box_owner == $box_owner->id ?'selected':'' }}>{{$box_owner->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>


                                        </div>
                                    </div>

                                </div>

                            </div>
                            <hr>
                            <input class="btn btn-primary btn-sm" type="submit" id="submit" name="submit"
                                   value="Submit" tabindex="17">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {

            $('form').submit(function (event) {
                /*
                                if(!$('select[name=vessel_id]')[0].checkValidity()){
                                    $('div[name=validation_box]').empty();
                                    $('div[name=validation_box]').html("Vessel Cannot be Empty");
                                    event.preventDefault();
                                } else if(!$('select[name=voyage_id]')[0].checkValidity()){
                                    $('div[name=validation_box]').empty();
                                    $('div[name=validation_box]').html("Voyage Cannot be Empty");
                                    event.preventDefault();
                                }else {

                                }
                */

            });

            var voyage_id = '{{$container->voyage_id}}';
            var ex_on_carrier_voyage = '{{$container->ex_on_carrier_voyage}}';

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
                }).always(function (d) {
                    $('select[name=voyage_id]').selectpicker('refresh');
                });
            });

            //on document load triggers one time.
            $('select[name=vessel_id]').trigger('change');

            $('select[name=ex_on_carrier_vessel]').bind('change', function (e) {

                var vessel = $(this).val();
                $('select[name=ex_on_carrier_voyage]').empty();
                $('select[name=ex_on_carrier_voyage]').append($("<option value=''>[SELECT]</option>"));

                $.ajax({
                    url: '{{url('api/voyage')}}/' + vessel,
                    method: 'get',
                }).done(function (voyage_list) {
                    $.each(voyage_list.data, function (k, v) {
                        var ex_voyage_option = $(v.option_element);
                        if (v.id == ex_on_carrier_voyage) {
                            ex_voyage_option.attr('selected', true);
                        }
                        $('select[name=ex_on_carrier_voyage]').append(ex_voyage_option);
                    });
                }).always(function (d) {
                    $('select[name=ex_on_carrier_voyage]').selectpicker('refresh');
                });
            });

            //on document load triggers one time.
            $('select[name=ex_on_carrier_vessel]').trigger('change');

            $('#datetimepicker4').datetimepicker({
                format: 'YYYY-MM-DD',
            });

            $('#datetimepicker3').datetimepicker({
                format: 'HH:mm'
            });
            $('select').selectpicker();
        });
    </script>
@endsection
