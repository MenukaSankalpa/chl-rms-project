@extends('layout.app')
@section('content')
    <h1 class="h3 mb-4 text-gray-800">Billing Details – Maersk Download</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{url('/mersk_report_download')}}" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="col-md-4">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label>From</label>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group date" id="datetimepicker4"
                                             data-target-input="nearest">
                                            <input type="text" name="from"
                                                   class="form-control form-control-sm datetimepicker-input"
                                                   data-target="#datetimepicker4" tabindex="9" value="{{\Carbon\Carbon::now()->startOfMonth()->toDateString()}}"/>
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
                                        <label>To</label>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group date" id="datetimepicker5"
                                             data-target-input="nearest">
                                            <input type="text" name="to"
                                                   class="form-control form-control-sm datetimepicker-input"
                                                   data-target="#datetimepicker5" tabindex="9" value="{{\Carbon\Carbon::now()->endOfMonth()->toDateString()}}"/>
                                            <div class="input-group-append" data-target="#datetimepicker5"
                                                 data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <hr>
                            <button class="btn btn-success btn-sm" type="submit" id="submit" name="download">
                                <i class="fa fa-download"></i> Download
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('#datetimepicker4').datetimepicker({
            format: 'YYYY-MM-DD',
        });
        $('#datetimepicker5').datetimepicker({
            format: 'YYYY-MM-DD',
        });
    </script>
    @endsection
