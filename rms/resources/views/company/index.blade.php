@extends('layout.app')
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Companies <a href="{{url('/company/create')}}" class="btn btn-primary btn-sm"><i
                    class="fa fa-plus-square"></i> New Company</a></h1>

    <div class="row">
        <div class="col-md-12">
            {{--data table--}}
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"></h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="companyTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                            <tr>
                                <th>company code</th>
                                <th>company name</th>
                                <th>Action</th>
                            </tr>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>company code</th>
                                <th>company name</th>
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
            $('#companyTable').DataTable( {
                processing: true,
                serverSide: true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                "ajax": 'data/company',
                columns: [
                    { data: 'code'},
                    { data: 'name'},
                    { data: 'action', orderable: false, searchable: false}
                ]
            } );
        } );
    </script>
@endsection