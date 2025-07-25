@extends('layout.app')
@section('side_bar')
@endsection
@section('nav_bar')
@endsection
@section('footer')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-6">
            <h4><strong>{{$container->container_number}} - {{$container->plug_on_date}} Monitoring Details</strong></h4>
            <div class="row">
                <div class="col-md-3"><strong>Container No.</strong></div>
                <div class="col-md-3"><strong>{{$container->container_number}}</strong></div>
                <div class="col-md-3"><strong>Yard Location.</strong></div>
                <div class="col-md-3"><strong>{{$container->yard_location}}</strong></div>
                <div class="col-md-3"><strong>Category.</strong></div>
                <div class="col-md-3"><strong>{{$container->ts_local}}</strong></div>
                <div class="col-md-3"><strong>Set Temp.</strong></div>
                <div class="col-md-3"><strong>{{$container->set_temp}}</strong></div>
                <div class="col-md-3"><strong>Plug on date</strong></div>
                <div class="col-md-3"><strong>{{$container->plug_on_date}}</strong></div>
                <div class="col-md-3"><strong>Plug off date</strong></div>
                <div class="col-md-3"><strong>{{$container->plug_off_date}}</strong></div>
                <div class="col-md-3"><strong>Plug on Time</strong></div>
                <div class="col-md-3"><strong>{{$container->plug_on_time}}</strong></div>
                <div class="col-md-3"><strong>Plug off Time</strong></div>
                <div class="col-md-3"><strong>{{$container->plug_off_time}}</strong></div>
                <div class="col-md-3"><strong>Plug on Temp</strong></div>
                <div class="col-md-3"><strong>{{$container->plug_on_temp}}</strong></div>
                <div class="col-md-3"><strong>Plug off temp</strong></div>
                <div class="col-md-3"><strong>{{$container->plug_off_temp}}</strong></div>
                <div class="col-md-3"><strong>Vessel</strong></div>
                <div class="col-md-3"><strong>{{$container->vessel?$container->vessel->name:''}}</strong></div>
                <div class="col-md-3"><strong>Voyage</strong></div>
                <div class="col-md-3"><strong>{{$container->voyage?$container->voyage->code:''}}</strong></div>
                <div class="col-md-3"><strong>Loading vessel</strong></div>
                <div class="col-md-3"><strong>{{$container->loading_vessel?$container->loading_vessel->name:''}}</strong></div>
                <div class="col-md-3"><strong>Loading Voyage</strong></div>
                <div class="col-md-3"><strong>{{$container->loading_voyage?$container->loading_voyage->code:''}}</strong></div>
                <div class="col-md-12">
                    <table class="table table-striped table-responsive table-sm table-bordered "
                           style="width: 100%; position: relative;">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>04:00</th>
                            <th>08:00</th>
                            <th>12:00</th>
                            <th>16:00</th>
                            <th>20:00</th>
                            <th>24:00</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($monitorings as $monitoring)
                            <tr>
                                <td><strong>{{$monitoring->date}}</strong></td>
                                <td>{{$monitoring->schedule_4}}</td>
                                <td>{{$monitoring->schedule_8}}</td>
                                <td>{{$monitoring->schedule_12}}</td>
                                <td>{{$monitoring->schedule_16}}</td>
                                <td>{{$monitoring->schedule_20}}</td>
                                <td>{{$monitoring->schedule_24}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
