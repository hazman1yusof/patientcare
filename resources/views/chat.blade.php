@extends('layouts.main')

@section('title')
Chat | Chat
@endsection

@section('css')
@endsection

@section('style')
@endsection

@section('js')
    <script src="{{ asset('js/chat.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h3 class="card-title">
                    Chat
                </h3>
                <div class="ui divider"></div>
                <div class="ui grid">
                    <div class="ten wide column">
                        <div class="ui fluid card">
                          <div class="content">
                            <div class="header">Cute Dog</div>
                            <div class="meta">
                              <span class="right floated time">2 days ago</span>
                              <span class="category">Animals</span>
                            </div>
                            <div class="description">
                              <p></p>
                            </div>
                          </div>
                          <div class="extra content">
                            <div class="right floated author">
                              <img class="ui avatar image" src="img/avatar/daniel.jpg"> Matt
                            </div>
                          </div>
                        </div>
                    </div>

                    <div class="sixteen wide column ui one stackable cards">
                        <div class="ui card">
                          <div class="content">
                            <div class="header">Cute Dog</div>
                            <div class="meta">
                              <span class="right floated time">2 days ago</span>
                              <span class="category">Animals</span>
                            </div>
                            <div class="description">
                              <p></p>
                            </div>
                          </div>
                          <div class="extra content">
                            <div class="right floated author">
                              <img class="ui avatar image" src="img/avatar/daniel.jpg"> Matt
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection