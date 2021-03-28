<div id="top"></div>
<a href="#top" class="ui circular icon button" id="toTop" data-slide="slide">
    <i class="angle up icon"></i>
</a>
<div class="ui fixed top menu sidemenu" id="sidemenu_topmenu">
    <a class="item" id="showSidebar"><i class="sidebar inverted icon"></i></a>
</div>

<div class="ui sidebar inverted vertical menu sidemenu">
    @if (Auth::user()->groupid == 'patient')
        <a class="item {{(Request::is('appointment') ? 'active' : '')}}" href="{{url('/appointment')}}"><i style="float: left" class="calendar alternate outline inverted icon big link"></i>Appointment</a>

        <a class="item @if(Request::is('chat2') || Request::is('chat2/*')) {{'active'}} @endif" href="{{ url('/chat2')}}"><i style="float: left" class="comments inverted big link icon"></i>Chat</a>

        <a class="item {{(Request::is('preview') ? 'active' : '')}}" href="{{ url('/preview')}}"><i style="float: left" class="folder open inverted big icon link"></i>Medical Images</a>

        <a class="item @if(Request::is('prescription') || Request::is('prescription/*')) {{'active'}} @endif" href="{{ url('/prescription')}}"><i style="float: left" class="hospital inverted big link icon"></i>Prescription</a>

    @else
        <a class="item {{(Request::is('appointment') ? 'active' : '')}}" href="{{url('/appointment')}}"><i style="float: left" class="calendar alternate outline inverted icon big link"></i>Appointment</a>

        <a class="item {{(Request::is('emergency') ? 'active' : '')}}" href="{{ url('/emergency')}}"><i style="float: left" class="folder open inverted big icon link"></i>Document Upload</a>

        <a class="item {{(Request::is('dialysis') ? 'active' : '')}}" href="{{ url('/dialysis')}}"><i style="float: left" class="heartbeat inverted big icon link"></i>Dialysis</a>

        <a class="item @if(Request::is('chat2') || Request::is('chat2/*')) {{'active'}} @endif" href="{{ url('/chat2')}}"><i style="float: left" class="comments inverted big link icon"></i>Chat</a>

        <a class="item @if(Request::is('prescription') || Request::is('prescription/*')) {{'active'}} @endif" href="{{ url('/prescription')}}"><i style="float: left" class="hospital inverted big link icon"></i>Prescription</a>

        <a class="item @if(Request::is('pivot') || Request::is('pivot/*')) {{'active'}} @endif" href="{{ url('/pivot')}}"><i style="float: left" class="chart line big link icon"></i>Data Analysis</a>
        
    @endif
    <a class="item" href=".\logout"><i style="float: left" class="plug inverted big icon link"></i>Log Out</a>
</div>
