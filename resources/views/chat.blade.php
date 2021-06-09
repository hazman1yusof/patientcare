@extends('layouts.main')

@section('title')
Chat | Chat
@endsection

@section('css')
@endsection

@section('style')
  .description{
    background-color: #f9f9f9 !important;
    height: 300px;
    overflow: auto;
    padding-top: 25px !important;
    padding: 1em 1em;
  }
  .greentop{
    background: #1c9639 !important;
  }
  .header,.meta{
    color: white !important;
  }
  .cont-desc{
    padding: 0px !important;
  }
  .cont-desc .item{
    padding: .5em .5em !important;
  }

  /* 1.5 Chat */
  .chat-box .chat-content {
    background-color: #f9f9f9 !important;
    height: 300px;
    overflow: hidden;
    padding-top: 25px !important;
  }
  .chat-box .chat-content .chat-item {
    display: inline-block;
    width: 100%;
    margin-bottom: 25px;
  }
  .chat-box .chat-content .chat-item.chat-right img {
    float: right;
  }
  .chat-box .chat-content .chat-item.chat-right .chat-details {
    margin-left: 0;
    margin-right: 70px;
    text-align: right;
  }
  .chat-box .chat-content .chat-item.chat-right .chat-details .chat-text {
    text-align: left;
    background-color: #21ba45;
    color: #fff;
  }
  .chat-box .chat-content .chat-item > img {
    float: left;
    width: 50px;
    border-radius: 50%;
  }
  .chat-box .chat-content .chat-item .chat-details {
    margin-left: 70px;
  }
  .chat-box .chat-content .chat-item .chat-details .chat-text {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.03);
    background-color: #fff;
    padding: 10px 15px;
    border-radius: 3px;
    width: auto;
    display: inline-block;
    font-size: 12px;
  }
  .chat-box .chat-content .chat-item .chat-details .chat-text img {
    max-width: 100%;
    margin-bottom: 10px;
  }
  .chat-box .chat-content .chat-item.chat-typing .chat-details .chat-text {
    background-image: url("../img/typing.svg");
    height: 40px;
    width: 60px;
    background-position: center;
    background-size: 60%;
    background-repeat: no-repeat;
  }
  .chat-box .chat-content .chat-item .chat-details .chat-time {
    margin-top: 5px;
    font-size: 12px;
    font-weight: 500;
    opacity: 0.6;
  }
  .chat-box .chat-form {
    padding: 0;
    position: relative;
  }
  .chat-box .chat-form .form-control {
    border: none;
    padding: 15px;
    height: 50px;
    padding-right: 70px;
    font-size: 13px;
    font-weight: 500;
    box-shadow: none;
    outline: none;
  }
  .chat-box .chat-form .btn {
    padding: 0;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    position: absolute;
    top: 50%;
    right: -5px;
    -webkit-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.03);
  }
  .chat-box .chat-form .btn i {
    margin-left: 0;
  }
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
                    <div class="six wide column">
                        <div class="ui fluid card">
                          <div class="greentop content">
                            <div class="header">Who's Online?</div>
                            <div class="meta">
                              <span>2 people online</span>
                            </div>
                          </div>
                          <div class="content cont-desc">
                            <div class="description">
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