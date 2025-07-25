@extends('layout.app')
@section('content')
    <div class="row justify-content-center">
        <div class=" col-md-8 mb-4" style="background: white">
            @markdown
            # How to Login ?
            By now you must be having a password and an e-mail address.
            You must first visit <{{url('/')}}>.
            When you visit the link following page will be shown to you.
            @endmarkdown
            <img src="{{url('image/help/landing_page.PNG')}}" class="mb-3" style="border: #1b1e21 5px solid" width="100%" >
            @markdown
            On top right corner of the landing page you will see the login link. click on it.
            @endmarkdown
            <img src="{{url('image/help/login_link.PNG')}}" class="mb-3" style="border: #1b1e21 5px solid" width="40%">
            @markdown
            then you will be directed to the following login page.
            @endmarkdown
            <img src="{{url('image/help/login_page.PNG')}}" class="mb-3"  style="border: #1b1e21 5px solid" width="100%">
            @markdown
            in the login page type your E-Mail in the **E-mail** input box and password in **Password** input box.
            if you want to save your login credentials tick on the remember me button.
            how ever most modern browsers saves your credentials despite you click or not.
            then click on the button login.

            ##### Nice if your credentials are correct now you will be logged in.

            @endmarkdown
        </div>
    </div>
@endsection
