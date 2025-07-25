@extends('layout.app')
@section('content')
    <a href="{{url('/vessel')}}" class=""><i class="fa fa-arrow-alt-circle-left"></i> Go Back </a>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Vessel</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                        <div class="form-group">
                            <div class="col-md-4">
                                <label>Vessel</label>
                                <select readonly required name="vessel_id" class="form-control" data-live-search="true">
                                    @foreach($vessels as $vessel)
                                        <option value="{{$vessel->id}}" {{($vessel->id==$voyage->vessel_id?'selected':'')}}>{{$vessel->name}}</option>
                                    @endforeach
                                </select>

                                <label>Code</label>
                                <input readonly type="text" class="form-control" name="code" id="code"
                                       placeholder="Code"
                                       value="{{$voyage->code}}"
                                       required>

                                <label>ETA</label>
                                <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                                    <input readonly type="text" name="eta" class="form-control datetimepicker-input"
                                           data-target="#datetimepicker4"
                                           value="{{$voyage->eta}}"
                                           required/>
                                    <div class="input-group-append" data-target="#datetimepicker4"
                                         data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
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
    <script>
        $(document).ready(function () {

            $('#datetimepicker4').datetimepicker({
                format: 'YYYY-MM-DD',
            });

            //$('select').selectpicker();

        });


    </script>
@endsection
