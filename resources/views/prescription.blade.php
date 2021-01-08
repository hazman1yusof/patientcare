@extends('layouts.main')

@section('title')
Dashboard &raquo; Document Prescription | Apps Prescription
@endsection

@section('style')
.ui.table td {
    padding: 22px;
}
.ui.table tr:hover {
    background: #f0f0f0;
    box-shadow: 1px 2px 5px #949494;
    cursor:pointer;
}
.ui.table th{
    color: #d93025 !important;
}
@endsection

@section('js')
    <script src="{{ asset('js/prescription.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h3 class="card-title">
                    Prescription
                </h3>
                <hr />
                @if(session('notification'))
                    <div
                        class="alert alert-{{ session('status') }} alert-dismissible fade show"
                        role="alert"
                    >
                        {{ session('notification') }}
                        <button
                            type="button"
                            class="close"
                            data-dismiss="alert"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div>
                    <form class="ui form ui grid">
                                       
                    <div class="four wide column">
                    <h4 class="card-title">
                    MRN: 8663
                    </h4>   
                    </div>
                     <div class="four wide column">
                    <h4 class="card-title">
                    NAME: NOR LIZAH BINTI YACOB
                    </h4>   
                    </div>
                    </form>
                </div>
                <hr/>
                
                <div class="table-responsive">
                    <table class="ui basic table">
                        <thead>
                            <tr>
                                <th scope="col" width="9%">Date</th>
                                <th scope="col">Description</th>
                                <th scope="col">Doctor</th>
                                <th scope="col">Dose</th>
                                <th scope="col">Freq</th>
                                <th scope="col">Instruction</th>
                                <th scope="col">Remark</th>
                                <th scope="col">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($table_prescription) == 0)
                                <tr>
                                    <td colspan="8" align="center"><b>Tidak ada data ...!</b></td>
                                </tr>
                            @endif
                            @foreach($table_prescription as $item)
                                <tr data-id="{{ $item->id }}">
                                    <td>{{ @$item->date }}</td>
                                    <td>{{ @$item->description }}</td>
                                    <td>{{ @$item->doctor }}</td>
                                    <td>{{ @$item->dosecode }}</td>
                                    <td>{{ @$item->freqcode }}</td>
                                    <td>{{ @$item->instcode }}</td>
                                    <td>{{ @$item->remark }}</td>
                                    <td>{{ @$item->qty }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @if ($table_prescription->lastPage() > 1)
                    <div class="ui pagination menu">
                        <a href="{{ $table_prescription->previousPageUrl() }}" class="{{ ($table_prescription->currentPage() == 1) ? ' disabled' : '' }} item">
                            Previous
                        </a>
                        @for ($i = 1; $i <= $table_prescription->lastPage(); $i++)
                            <a href="{{ $table_prescription->url($i) }}" class="{{ ($table_prescription->currentPage() == $i) ? ' active' : '' }} item">
                                {{ $i }}
                            </a>
                        @endfor
                        <a href="{{ $table_prescription->nextPageUrl() }}" class="{{ ($table_prescription->currentPage() == $table_prescription->lastPage()) ? ' disabled' : '' }} item">
                            Next
                        </a>
                    </div>
                @endif
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection