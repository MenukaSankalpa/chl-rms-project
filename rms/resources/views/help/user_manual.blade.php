@extends('layout.app')
@section('content')
    <div class="row justify-content-center">
        <div class=" col-md-8 mb-4" style="background: white">
            <embed src="{{url('/documents/user_guide.pdf')}}" type="application/pdf" width="100%" height="1000px" />
        </div>
    </div>
@endsection
