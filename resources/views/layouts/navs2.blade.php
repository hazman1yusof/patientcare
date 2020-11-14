<div id="top"></div>
<a href="#top" class="ui circular icon button" id="toTop" data-slide="slide">
    <i class="angle up icon"></i>
</a>
<div class="ui fixed top menu sidemenu">
    <a class="item"><i class="sidebar inverted icon" id="showSidebar"></i></a>
</div>

<div class="ui sidebar inverted vertical menu sidemenu">
    <a class="item {{(Request::is('appointment') ? 'active' : '')}}" href="\appointment">
        <i style="float: left" class="calendar alternate outline inverted icon big link"></i>
    Appointment</a>
    <a class="item @if(Request::is('ticket') || Request::is('ticket/*')) {{'active'}} @endif" href="\ticket"><i class="comments inverted big link icon"></i>Question Posts</a>
    @if(Auth::check() && Auth::user()->type=='doctor')
        <a class="item {{(Request::is('patient') ? 'active' : '')}}" href="\patient"><i class="comments inverted big link icon"></i>Patient</a>
        <a class="item {{(Request::is('doctor') ? 'active' : '')}}" href="\doctor"><i class="comments inverted big link icon"></i>Doctor</a>
    @endif

    @if(Auth::check() && Auth::user()->type=='doctor')
        <a class="item {{(Request::is('preview') ? 'active' : '')}}" href="\preview"><i class="comments inverted big link icon"></i>Medical Images</a>
    @endif

    <!-- <a class="item" href="\settings\change_password">Change Password</a> -->
    <a class="item" href="\logout">Log Out</a>
</div>

<div class="ui left fixed vertical icon menu sidemenu">
    <a class="item {{(Request::is('appointment') ? 'active' : '')}}" data-content="Appointment" href="\appointment"><i class="calendar alternate outline inverted big icon link"></i></a>
    <a class="item @if(Request::is('ticket') || Request::is('ticket/*')) {{'active'}} @endif" data-content="Question Posts" href="\ticket"><i class="comments inverted big link icon"></i></a>
    @if(Auth::check() && Auth::user()->type=='doctor')
        <a class="item @if(Request::is('patient') || Request::is('agent_detail/*')) {{'active'}} @endif" data-content="Patient" href="\patient"><i class="users inverted big link icon"></i></a>
        <a class="item {{(Request::is('doctor') ? 'active' : '')}}" data-content="Doctor" href="\doctor"><i class="user md inverted big link icon"></i></a>
    @endif

    @if(Auth::check() && Auth::user()->type=='doctor')
        <a class="item {{(Request::is('preview') ? 'active' : '')}}" data-content="Medical Images" href="\preview?mrn=1"><i class="folder open inverted big icon link"></i></a>
    @endif
    <!-- <a class="item {{(Request::is('settings/change_password') ? 'active' : '')}}" data-content="Change Password" href="\settings\change_password"><i class="settings inverted big link icon"></i></a> -->
    <a class="item {{(Request::is('login') ? 'active' : '')}}" data-content="Log Out" href="\logout"><i class="plug inverted big icon"></i></a>
</div>