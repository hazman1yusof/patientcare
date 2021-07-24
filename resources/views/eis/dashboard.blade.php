@extends('layout-stisla.admin-master')

@section('title')
Dashboard
@endsection

@section('stylesheet')
@endsection

@section('header')
<script>
  var ip_month = [{{implode(",",$ip_month)}}];
  var op_month = [{{implode(",",$op_month)}}];
  var groupdesc_val_op = [{{implode(",",$groupdesc_val_op)}}];
  var groupdesc_val_ip = [{{implode(",",$groupdesc_val_ip)}}];
  var groupdesc_val = [{{implode(",",$groupdesc_val)}}];
</script>
@endsection

@section('css')
  .blue{
    color:#47aeff;;
  }
  .red{
    color:#f44336;
  }
@endsection

@section('content')

<section class="section">

  <div class="row justify-content-center">
    <div class="col-8">
      <div class="card">
        <div class="card-header">
          <h4>Bar Chart - Weekly</h4>
          <div class="dropdown d-inline">
                      <a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#" id="orders-month" aria-expanded="false">August</a>
                      <ul class="dropdown-menu dropdown-menu-sm" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 17px, 0px);">
                        <li class="dropdown-title">Select Month</li>
                        <li><a href="#" class="dropdown-item">January</a></li>
                        <li><a href="#" class="dropdown-item">February</a></li>
                        <li><a href="#" class="dropdown-item">March</a></li>
                        <li><a href="#" class="dropdown-item">April</a></li>
                        <li><a href="#" class="dropdown-item">May</a></li>
                        <li><a href="#" class="dropdown-item">June</a></li>
                        <li><a href="#" class="dropdown-item">July</a></li>
                        <li><a href="#" class="dropdown-item active">August</a></li>
                        <li><a href="#" class="dropdown-item">September</a></li>
                        <li><a href="#" class="dropdown-item">October</a></li>
                        <li><a href="#" class="dropdown-item">November</a></li>
                        <li><a href="#" class="dropdown-item">December</a></li>
                      </ul>
                    </div>
        </div>
        <div class="card-body">
          <canvas id="myChart2" style="display: block; width: 732px; height: 266px;" class="chartjs-render-monitor"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    
    <div class="col-lg-4">
      <div class="card gradient-bottom">
        <div class="card-header">
          <h4>Chart by group</h4>
        </div>
        <div class="card-body niceScroll" tabindex="2" style="height: 315px; overflow: hidden; outline: none;">
          <ul class="list-unstyled list-unstyled-border">
            @foreach ($groupdesc as $index => $_groupdesc)

              <li class="media">
                <div class="media-body">
                  <div class="float-right"><div class="font-weight-600 text-muted text-small">{{ $groupdesc_val[$index] }}</div></div>
                  <div class="media-title">{{ $_groupdesc }}</div>
                  <div class="mt-1">
                    <div class="budget-price">
                      <div class="budget-price-square bg-primary" data-width="{{ $groupdesc_val_ip_percent[$index] }}%" style="width: {{ $groupdesc_val_ip_percent[$index] }}%;"></div>
                      <div class="budget-price-label">{{ $groupdesc_val_ip[$index] }}</div>
                    </div>
                    <div class="budget-price">
                      <div class="budget-price-square bg-danger" data-width="{{ $groupdesc_val_op_percent[$index] }}%" style="width: {{ $groupdesc_val_op_percent[$index] }}%;"></div>
                      <div class="budget-price-label">{{ $groupdesc_val_op[$index] }}</div>
                    </div>
                  </div>
                </div>
              </li>

            @endforeach
          </ul>
        </div>
        <div class="card-footer pt-3 d-flex justify-content-center">
          <div class="budget-price justify-content-center">
            <div class="budget-price-square bg-primary" data-width="20" style="width: 20px;"></div>
            <div class="budget-price-label">IN PATIENT</div>
          </div>
          <div class="budget-price justify-content-center">
            <div class="budget-price-square bg-danger" data-width="20" style="width: 20px;"></div>
            <div class="budget-price-label">OUT PATIENT</div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-8">
      <div class="card card-hero">
        <div class="card-header p-3">
          <div class="card-icon">
            <i class="fas fa-search-dollar"></i>
          </div>
          <h3>Revenues</h3>
        </div>
        <div class="card-body niceScroll" style="height: 315px; overflow: hidden; outline: none;">
          <div class="table-responsive table-invoice">
            <table class="table table-striped">
              <tbody>
              <tr>
                <th>GROUP</th>
                <th class="blue">IN PATIENT</th>
                <th class="red">OUT PATIENT</th>
                <th>TOTAL</th>
              </tr>
              @foreach ($groupdesc as $index => $_groupdesc)
                <tr>
                  <th>{{ $_groupdesc }}</th>
                  <th class="blue">{{ $groupdesc_val_ip[$index] }}</th>
                  <th class="red">{{ $groupdesc_val_op[$index] }}</th>
                  <th>{{ $groupdesc_val[$index] }}</th>
                </tr>
              @endforeach
            </tbody></table>
          </div>
        </div>
        <div class="card-footer pt-3 d-flex justify-content-center">
          <div class="budget-price justify-content-center">
            <div class="budget-price-square bg-primary" data-width="20" style="width: 20px;"></div>
            <div class="budget-price-label">IN PATIENT</div>
          </div>
          <div class="budget-price justify-content-center">
            <div class="budget-price-square bg-danger" data-width="20" style="width: 20px;"></div>
            <div class="budget-price-label">OUT PATIENT</div>
          </div>
        </div>
      </div>
    </div>
  </div>

</section>
@endsection

@section('scripts')
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endsection

@section('stylesheet')
@endsection
