@extends('layout.app')
@section('content')
    <a href="{{url('/company')}}" class=""><i class="fa fa-arrow-alt-circle-left"></i> Go Back </a>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Company</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                        <div class="form-group">

                            <div class="row">

                            <div class="col-md-4">
                                <label>Code</label>
                                <input type="text" class="form-control" name="code" id="code"
                                       placeholder="Code"
                                       value="{{$company->code}}"
                                       required readonly>

                                <label>Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                       placeholder="name"
                                       value="{{$company->name}}"
                                       required readonly>
                            </div>

                            <div class="col-md-6">
                                <label>Addresses</label>
                                <table class="table table-striped table-sm" name="address_table">
                                    <thead>
                                    </thead>
                                    <tbody>
                                    @foreach($company->addresses as $address)
                                        <tr>
                                            <td>
                                                <span name="addresses">{{$address->address}}</span>
                                                <input type="hidden" name="addresses[]" value="{{$address->address}}">
                                            </td>
                                            <td>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>

                            </div>

                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
