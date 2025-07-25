@extends('layout.app')
@section('content')
    <a href="{{url('/voyage')}}" class=""><i class="fa fa-arrow-alt-circle-left"></i> Go Back </a>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Create Voyage</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{url('/voyage')}}" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="col-md-4">
                                @csrf
                                <label>Vessel</label>
                                <select required name="vessel_id" class="form-control" data-live-search="true">
                                    @foreach($vessels as $vessel)
                                        <option value="{{$vessel->id}}">{{$vessel->name}}</option>
                                    @endforeach
                                </select>

                                <label>Code</label>
                                <input type="text" class="form-control" name="code" id="code"
                                       placeholder="Code"
                                       maxlength="10"
                                       required>

                                <label>ETA</label>
                                <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                                    <input type="text" name="eta" class="form-control datetimepicker-input"
                                           data-target="#datetimepicker4" required/>
                                    <div class="input-group-append" data-target="#datetimepicker4"
                                         data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>


                            </div>
                            <hr>
                            <input class="btn btn-primary btn-sm" type="submit" id="submit" name="submit"
                                   value="Submit">
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

            $('#datetimepicker4').datetimepicker({
                format: 'YYYY-MM-DD',
            });

            $('select').selectpicker();

        });


    </script>
@endsection