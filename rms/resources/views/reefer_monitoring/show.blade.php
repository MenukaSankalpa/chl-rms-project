@extends('reefer_monitoring.index')
@section('file_id',$file->id)

@section('_title')
    Reefer Monitoring By Excel
    <a href="{{url('reefer_monitoring/')}}" class="btn btn-primary btn-sm">
        <i class="fa fa-arrow-circle-right "></i> Back to Default Search </a>
@endsection

@section('vessel_id')
    <select name="vessel_id"
            class="form-control form-control-sm"
            data-live-search="true"
            tabindex="1">
        <option value=''>[SELECT]</option>
        @foreach($vessels as $vessel)
            <option
                value="{{$vessel->id}}" {{$vessel->id == $data->vessel_id?'selected':''}}>{{$vessel->name}}</option>
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
