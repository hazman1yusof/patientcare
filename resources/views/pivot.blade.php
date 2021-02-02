@extends('layouts.main')

@section('title')
Pivot | Pivot
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.13.0/pivot.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.min.css">
@endsection

@section('style')
    .pvtFilterBox{
        z-index: 120 !important;
    }
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.13.0/pivot.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.23.0/c3_renderers.min.js"></script>
    <script src="{{ asset('js/pivot.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h3 class="card-title">
                    Pivot
                </h3>

                <div class="ui form">
                  <div class="grouped fields">
                    <h3 class="ui header">Data Analysis Type: </h3>
                    <div class="field">
                      <div class="ui slider checkbox">
                        <input type="radio" name="throughput" checked="checked" value="dis">
                        <label>Discharge</label>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui slider checkbox">
                        <input type="radio" name="throughput" value="reg">
                        <label>Registration</label>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="ui divider"></div>

                <div id="output">
                    
                </div>
                
                
              </div>
            </div>
        </div>
    </div>
</div>
@endsection