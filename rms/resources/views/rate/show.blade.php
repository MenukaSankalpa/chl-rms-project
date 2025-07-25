@extends('layout.app')
@section('content')
    <a href="{{url('/rate')}}" class=""><i class="fa fa-arrow-alt-circle-left"></i> Go Back </a>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">rate</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="col-md-4">
                        <label>Rate</label>
                        <input type="number" step="0.01" class="form-control" name="rate" id="rate"
                               placeholder="Rate"
                               value="{{$rate->rate}}"
                               required>

                        <label>Date</label>
                        <div class="input-group date" id="datetimepicker4"
                             data-target-input="nearest">
                            <input value="{{$rate->date}}" type="text" name="date"
                                   class="form-control datetimepicker-input"
                                   data-target="#datetimepicker4" tabindex="9"/>
                            <div class="input-group-append" data-target="#datetimepicker4"
                                 data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>

                        <label>Box Owner</label>
                        <select name="box_owner_id"
                                class="form-control"
                                data-live-search="true" tabindex="16" required>
                            <option value="">[SELECT]</option>
                            @foreach($box_owners as $box_owner)
                                <option
                                    value="{{$box_owner->id}}" {{$box_owner->id==$rate->box_oner_id?'selected':''}}>{{$box_owner->name}}</option>
                            @endforeach
                        </select>

                        <label>Currency</label>
                        <select name="currency"
                                class="form-control"
                                data-live-search="true" tabindex="4">
                            <option value="1" {{$rate->currency==1?'selected':''}}>LKR</option>
                            <option value="2" {{$rate->currency==2?'selected':''}}>USD</option>
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
