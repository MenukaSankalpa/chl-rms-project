@extends('layout.app')
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Ports <a href="{{url('/yard/create')}}" class="btn btn-primary btn-sm"><i
                    class="fa fa-plus-square"></i> New Yard</a></h1>

    <div class="row">
        <div class="col-md-12">
            {{--data table--}}
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"></h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="yardTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                            <tr>
                                <th>Yard code</th>
                                <th>Yard name</th>
                                <th>Action</th>
                            </tr>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Yard code</th>
                                <th>Yard name</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#yardTable').DataTable( {
                processing: true,
                serverSide: true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                "ajax": 'data/yard',
                columns: [
                    { data: 'code'},
                    { data: 'name'},
                    { data: 'action', orderable: false, searchable: false}
                ]
            } );
        } );
    </script>
@endsection