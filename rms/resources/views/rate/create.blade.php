@extends('layout.app')
@section('content')
    <a href="{{url('/rate')}}" class=""><i class="fa fa-arrow-alt-circle-left"></i> Go Back </a>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Create rate</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{url('/rate')}}" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="col-md-4">
                                @csrf
                                <label>Rate</label>
                                <input type="number" step="0.01" class="form-control" name="rate" id="rate"
                                       placeholder="Rate"
                                       required>

                                <label>Date</label>
                                <div class="input-group date" id="datetimepicker4"
                                     data-target-input="nearest">
                                    <input type="text" name="date"
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
                                            value="{{$box_owner->id}}">{{$box_owner->name}}</option>
                                    @endforeach
                                </select>

                                <label>Currency</label>
                                <select name="currency"
                                        class="form-control"
                                        data-live-search="true" tabindex="4">
                                    <option value="1">LKR</option>
                                    <option value="2">USD</option>
                                    </option>
                                </select>


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

        })
    </script>
    @endsection
