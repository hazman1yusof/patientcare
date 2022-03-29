<div class="ui fixed top menu sidemenu" id="sidemenu_topmenu">
    <a class="item" id="showSidebar"><i class="sidebar inverted icon"></i></a>
    <div class="right menu">
        <div class="ui dropdown item" style="color:white;">
          Hi, {{Auth::user()->name}} !<i class="dropdown icon"></i>
          <div class="menu">
            <a class="item" href="{{ url('user/editpassword')}}/{{Auth::user()->id}}">Change Password</a>
            <a class="item" href="{{ url('/logout')}}">Log Out</a>
          </div>
        </div>
    </div>
</div>



<div class="ui sidebar inverted vertical menu sidemenu">
    @if (strtoupper(Auth::user()->groupid) == 'PATIENT')
        <a class="item {{(Request::is('appointment') ? 'active' : '')}}" href="{{url('/appointment')}}"><i style="float: left" class="calendar alternate outline inverted icon big link"></i>Appointment</a>

        @if(Auth::user()->televideo == 'true')
            <a class="item @if(Request::is('chat2') ) {{'active'}} @endif" href="{{ url('/chat2')}}"><i style="float: left" class="comments inverted big link icon"></i>Tele-video</a>
        @endif

        <a class="item @if(Request::is('chat') ) {{'active'}} @endif" href="{{ url('/chat')}}"><i style="float: left" class="comments inverted big link icon"></i>Whatsapp web</a>

        <a class="item {{(Request::is('preview') ? 'active' : '')}}" href="{{ url('/preview')}}"><i style="float: left" class="folder open inverted big icon link"></i>Medical Images</a>

        <a class="item @if(Request::is('prescription') || Request::is('prescription/*')) {{'active'}} @endif" href="{{ url('/prescription')}}"><i style="float: left" class="hospital inverted big link icon"></i>Prescription</a>

    @elseif (strtoupper(Auth::user()->groupid) == 'DOCTOR')
        <a class="item {{(Request::is('emergency') ? 'active' : '')}}" href="{{ url('/emergency')}}"><i style="float: left" class="folder open inverted big icon link"></i>Document Upload</a>

        <a class="item {{(Request::is('doctornote') ? 'active' : '')}}" href="{{ url('/doctornote')}}"><i style="float: left" class="stethoscope inverted big icon link"></i>Doctor Note</a>

        <a class="item @if(Request::is('chat') || Request::is('chat/*')) {{'active'}} @endif" href="{{ url('/chat')}}"><i style="float: left" class="comments inverted big link icon"></i>Chat</a>

    @elseif (strtoupper(Auth::user()->groupid) == 'CLINICAL')
        <a class="item {{(Request::is('dashboard') ? 'active' : '')}}" href="{{url('/dashboard')}}"><i style="float: left" class="home inverted icon big link"></i>Dashboard</a>

        <a class="item {{(Request::is('appointment') ? 'active' : '')}}" href="{{url('/appointment')}}"><i style="float: left" class="calendar alternate outline inverted icon big link"></i>Appointment</a>

        <a class="item {{(Request::is('emergency') ? 'active' : '')}}" href="{{ url('/emergency')}}"><i style="float: left" class="folder open inverted big icon link"></i>Document Upload</a>

        <a class="item {{(Request::is('doctornote') ? 'active' : '')}}" href="{{ url('/doctornote')}}"><i style="float: left" class="stethoscope inverted big icon link"></i>Doctor Note</a>

        <a class="item @if(Request::is('chat') || Request::is('chat/*')) {{'active'}} @endif" href="{{ url('/chat')}}"><i style="float: left" class="comments inverted big link icon"></i>Chat</a>


    @elseif (strtoupper(Auth::user()->groupid) == 'ADMIN')
        <a class="item {{(Request::is('dashboard') ? 'active' : '')}}" href="{{url('/dashboard')}}"><i style="float: left" class="home inverted icon big link"></i>Dashboard</a>

        <a class="item {{(Request::is('appointment') ? 'active' : '')}}" href="{{url('/appointment')}}"><i style="float: left" class="calendar alternate outline inverted icon big link"></i>Appointment</a>

        <a class="item {{(Request::is('emergency') ? 'active' : '')}}" href="{{ url('/emergency')}}"><i style="float: left" class="folder open inverted big icon link"></i>Document Upload</a>

        <a class="item {{(Request::is('doctornote') ? 'active' : '')}}" href="{{ url('/doctornote')}}"><i style="float: left" class="stethoscope inverted big icon link"></i>Doctor Note</a>

        @if(Auth::user()->televideo == 'true')
            <a class="item @if(Request::is('chat2') ) {{'active'}} @endif" href="{{ url('/chat2')}}"><i style="float: left" class="comments inverted big link icon"></i>Tele-video</a>
        @endif

        <a class="item @if(Request::is('chat') ) {{'active'}} @endif" href="{{ url('/chat')}}"><i style="float: left" class="comments inverted big link icon"></i>Whatsapp web</a>

        <a class="item @if(Request::is('prescription') || Request::is('prescription/*')) {{'active'}} @endif" href="{{ url('/prescription')}}"><i style="float: left" class="hospital inverted big link icon"></i>Prescription</a>

        <a class="item @if(Request::is('eis') || Request::is('eis/*')) {{'active'}} @endif" href="{{ url('/eis')}}"><i style="float: left" class="chart bar big link icon"></i>Episode Statistics</a>

        <a class="item @if(Request::is('reveis') || Request::is('reveis/*')) {{'active'}} @endif" href="{{ url('/reveis')}}"><i style="float: left" class="chart line big link icon"></i>Revenue By Services</a>

        <a class="item @if(Request::is('userlist') || Request::is('user/*')) {{'active'}} @endif" href="{{ url('/userlist')}}"><i style="float: left" class="big user icon"></i>User</a>

        <a class="item @if(Request::is('dialysis') || Request::is('dialysis/*')) {{'active'}} @endif" href="{{ url('/dialysis')}}"><i style="float: left" class="big procedures icon"></i>Dialysis</a>

    @elseif (strtoupper(Auth::user()->groupid) == 'MR')

        <a class="item {{(Request::is('dashboard') ? 'active' : '')}}" href="{{url('/dashboard')}}"><i style="float: left" class="home inverted icon big link"></i>Dashboard</a>

        <a class="item @if(Request::is('eis') || Request::is('eis/*')) {{'active'}} @endif" href="{{ url('/eis')}}"><i style="float: left" class="chart bar big link icon"></i>Episode Statistics</a>

        <a class="item @if(Request::is('reveis') || Request::is('reveis/*')) {{'active'}} @endif" href="{{ url('/reveis')}}"><i style="float: left" class="chart line big link icon"></i>Revenue By Services</a>

        @if(Auth::user()->televideo == 'true')
            <a class="item @if(Request::is('chat2') ) {{'active'}} @endif" href="{{ url('/chat2')}}"><i style="float: left" class="comments inverted big link icon"></i>Tele-video</a>
        @endif

        <a class="item @if(Request::is('chat') ) {{'active'}} @endif" href="{{ url('/chat')}}"><i style="float: left" class="comments inverted big link icon"></i>Whatsapp web</a>

        <a class="item {{(Request::is('emergency') ? 'active' : '')}}" href="{{ url('/emergency')}}"><i style="float: left" class="folder open inverted big icon link"></i>Document Upload</a>


    @else
        <a class="item {{(Request::is('dashboard') ? 'active' : '')}}" href="{{url('/dashboard')}}"><i style="float: left" class="home inverted icon big link"></i>Dashboard</a>

        <a class="item {{(Request::is('appointment') ? 'active' : '')}}" href="{{url('/appointment')}}"><i style="float: left" class="calendar alternate outline inverted icon big link"></i>Appointment</a>

        <a class="item {{(Request::is('doctornote') ? 'active' : '')}}" href="{{ url('/doctornote')}}"><i style="float: left" class="stethoscope inverted big icon link"></i>Doctor Note</a>

        @if(Auth::user()->televideo == 'true')
            <a class="item @if(Request::is('chat2') ) {{'active'}} @endif" href="{{ url('/chat2')}}"><i style="float: left" class="comments inverted big link icon"></i>Tele-video</a>
        @endif

        <a class="item @if(Request::is('chat') ) {{'active'}} @endif" href="{{ url('/chat')}}"><i style="float: left" class="comments inverted big link icon"></i>Whatsapp web</a>

<!-- 
        <a class="item {{(Request::is('preview') ? 'active' : '')}}" href="{{ url('/preview')}}"><i style="float: left" class="folder open inverted big icon link"></i>Medical Images</a> -->

        <a class="item @if(Request::is('prescription') || Request::is('prescription/*')) {{'active'}} @endif" href="{{ url('/prescription')}}"><i style="float: left" class="hospital inverted big link icon"></i>Prescription</a>
        
        <a class="item @if(Request::is('eis') || Request::is('eis/*')) {{'active'}} @endif" href="{{ url('/eis')}}"><i style="float: left" class="chart bar big link icon"></i>Episode Statistics</a>

        <a class="item @if(Request::is('reveis') || Request::is('reveis/*')) {{'active'}} @endif" href="{{ url('/reveis')}}"><i style="float: left" class="chart line big link icon"></i>Revenue By Services</a>

        <a class="item @if(Request::is('dialysis') || Request::is('dialysis/*')) {{'active'}} @endif" href="{{ url('/dialysis')}}"><i style="float: left" class="big procedures icon"></i>Dialysis</a>
        
    @endif
    <a class="item" href=".\logout"><i style="float: left" class="plug inverted big icon link"></i>Log Out</a>
</div>