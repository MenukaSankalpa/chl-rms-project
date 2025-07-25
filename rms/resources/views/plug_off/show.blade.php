@extends('reefer_monitoring.index')
@section('file_id',$file->id)

@section('_title')
    Plug Off By Excel
    <a href="{{url('plug_off/')}}" class="btn btn-primary btn-sm">
        <i class="fa fa-arrow-circle-right "></i> Back to Default Search </a>
@endsection

@section('redirect_link','/read/plug_off_excel/')
@section('plug_cat','plug_on_and_off_only')
@section('toggle_column_check_boxes')
    <div class="col-md-2">
        <small style="font-weight: bold">container no.</small>
        <input type="checkbox" class="" name="toggle_container_number"
               data-col-index="1" checked>
    </div>
    <div class="col-md-2">
        <small style="font-weight: bold">Yard Loc.</small>
        <input type="checkbox" class="" name="toggle_yard_location"
               data-col-index="2" checked>
    </div>
    <div class="col-md-2">
        <small style="font-weight: bold">Set Temp</small>
        <input type="checkbox" class="" name="toggle_set_temp"
               data-col-index="3" checked>
    </div>
    <div class="col-md-2">
        <small style="font-weight: bold">Plug On Date</small>
        <input type="checkbox" class="" name="toggle_plug_on_date"
               data-col-index="4" checked>
    </div>
    <div class="col-md-2">
        <small style="font-weight: bold">Plug On time</small>
        <input type="checkbox" class="" name="toggle_plug_on_time"
               data-col-index="5" checked>
    </div>
    <div class="col-md-2">
        <small style="font-weight: bold">Plug On temp</small>
        <input type="checkbox" class="" name="toggle_plug_on_time"
               data-col-index="6">
    </div>
    <div class="col-md-2">
        <small style="font-weight: bold">Temp Unit</small>
        <input type="checkbox" class="" name="toggle_temperature_unit"
               data-col-index="7" checked>
    </div>
    <div class="col-md-2">
        <small style="font-weight: bold">plug off</small>
        <input type="checkbox" class="" name="toggl_plug_off"
               checked>
    </div>
@endsection
@section('key')
@endsection
@section('thead')
    <thead>
    <tr>
    <tr>
        <th></th>
        <th>container no.</th>
        <th>Yard Loc</th>
        <th>Set Temp</th>
        <th>Plug on Date</th>
        <th>Plug on time</th>
        <th>Plug on temp</th>
        <th>Temp Unit</th>
        <th>Plug on/off only</th>
        {{--<th>on/off Only</th>--}}
        <th>Plug off Date</th>
        <th>Plug off time</th>
        <th>Plug off temp</th>
        <th>Quick Save</th>
        {{--<th>Action</th>--}}
    </tr>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th></th>
        <th>container no.</th>
        <th>Yard Loc</th>
        <th>Set Temp</th>
        <th>Plug on Date</th>
        <th>Plug on time</th>
        <th>Plug on temp</th>
        <th>Temp Unit</th>
        <th>Plug on/off only</th>
        {{--<th>on/off Only</th>--}}
        <th>Plug off Date</th>
        <th>Plug off time</th>
        <th>Plug off temp</th>
        <th>Quick Save</th>
        {{--<th>Action</th>--}}
    </tr>
    </tfoot>
@endsection
@section('dt_col')

    columns: [
    {data: 'empty', orderable: false},
    {data: 'container_number'},
    {data: 'yard_location'},
    {data: 'set_temp', orderable: false},
    {data: 'plug_on_date'},
    {data: 'plug_on_time', orderable: false},
    {data: 'plug_on_temp', orderable: false},
    {data: 'temperature_unit', orderable: false},
    {data: 'plugging_category', orderable: false},
    //{data: 'plugging_category',orderable: false, searchable: false,},
    {data: 'plug_off_date'},
    {data: 'plug_off_time', orderable: false},
    {data: 'plug_off_temp', orderable: false},

    {data: 'quick_save', orderable: false, searchable: false, all: true},
    //{data: 'delete', orderable: false, searchable: false, all: true},
    // {data: 'action', orderable: false, searchable: false, all: true}
    ],
@endsection

@section('vessel_id')
    <select name="vessel_id"
            class="form-control form-control-sm"
            data-live-search="true"
            tabindex="1">
        <option value=''>[SELECT]</option>

        @foreach($vessels as $vessel)
            <option
                value="{{$vessel->id}}"
                {{$vessel->id == $data->vessel_id ? 'selected':''}}>{{$vessel->name}}</option>
        @endforeach
    </select>
@endsection

@section('plug_off', isset($data->plug_off)?'checked':'')

@section('ld_both', $data->loading_discharging=="B"?'selected':'')
@section('ld_discharging', $data->loading_discharging=="D"?'selected':'')
@section('ld_loading', $data->loading_discharging=="L"?'selected':'')

@section('voyage_id', $data->voyage_id??'')
@section('box_owner')
    {{--<div class="form-group row">--}}
    {{--<div class="col-md-6">--}}
    {{--<label>Box Owner</label>--}}
    {{--</div>--}}
    {{--<div class="col-md-6">--}}
    {{--<select name="box_owner" class="form-control form-control-sm"--}}
    {{--data-live-search="true" tabindex="16" required>--}}
    {{--<option value="">[SELECT]</option>--}}
    {{--@foreach($box_owners as $box_owner)--}}
    {{--<option--}}
    {{--value="{{$box_owner->id}}" {{$box_owner->id == $data->box_owner?'selected':''}}>{{$box_owner->name}}</option>--}}
    {{--@endforeach--}}
    {{--</select>--}}
    {{--</div>--}}
    {{--</div>--}}
@endsection
@section('date',$data->date)
