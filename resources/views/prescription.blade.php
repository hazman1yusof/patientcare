@extends('layouts.main')

@section('title')
Dashboard &raquo; Document Prescription | Apps Prescription
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
                        <select
                            name="filter_year"
                            id="filter_year"
                            class="ui dropdown"
                            style="width: 100px"
                        >
                            <option value="">---Year---</option>
                            @for($y=2019;$y<=date('Y');$y++)
                                <option value="{{ $y }}" {{ $filter_year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="four wide column">
                        <input type="text" name="filter_text" class="form-control" placeholder="Masukkan kata kunci" style="width: 250px" value="{{ $filter_text }}">
                    </div>
                    </form>
                </div>
                <hr/>
                <div>
                    <button type="submit" class="ui button">View</button>
                    <a href="{{ url('#') }}" class="ui button">
                        <i class="fa fa-plus"></i> Add Data
                    </a>
                </div>
                <hr/>
                <div class="table-responsive">
                    <table class="ui celled striped table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">MRN</th>
                                <th scope="col">Episode</th>
                                <th scope="col">Name</th>
                                <th scope="col">PSNO</th>
                                <th scope="col">TRX Date</th>
                                <th scope="col">CHG Code</th>
                                <th scope="col">Description</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Unit Price</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Type</th>
                                <th scope="col">Dosage</th>
                                <th scope="col">Freq</th>
                                <th scope="col">Duration</th>
                                <th scope="col">Instruction</th>
                                <th scope="col">AddInstruction</th>
                                <th scope="col">Doctor</th>
                                <th scope="col">Action1</th>
                                <th scope="col">Action2</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($table_prescription) == 0)
                                <tr>
                                    <td colspan="8" align="center"><b>Tidak ada data ...!</b></td>
                                </tr>
                            @endif
                            @foreach($table_prescription as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->mrn }}</td>
                                    <td>{{ @$item->episode }}</td>
                                    <td>{{ @$item->name }}</td>
                                    <td>{{ @$item->psno }}</td>
                                    <td>{{ date('d-m-Y', strtotime($item->trxdate)) }}</td>
                                    <td>{{ @$item->chgcode }}</td>
                                    <td>{{ @$item->description }}</td>
                                    <td>{{ @$item->qty }}</td>
                                    <td>{{ @$item->unitprice }}</td>
                                    <td>{{ $item->amount }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td>{{ $item->dosage }}</td>
                                    <td>{{ @$item->freq }}</td>
                                    <td>{{ @$item->duration }}</td>
                                    <td>{{ @$item->instruction }}</td>
                                    <td>{{ @$item->addinstructon }}</td>
                                    <td>{{ @$item->doctor }}</td>
                                    <td>
                                        <a
                                            href="{{ url('uploads/documents/surat-masuk/') }}"
                                            class="btn btn-sm btn-primary text-white"
                                            target="_blank"
                                        >
                                            <i class="fa fa-bars"></i> View Detail
                                        </a>
                                    </td>
                                    <td>
                                        <a
                                            <a href="{{ url('prescription/cetak_pdf') }}" class="btn btn-sm btn-primary text-white" target="_blank"
                                        >
                                            <i class="fa fa-file-pdf"></i> View Pdf
                                        </a>
                                       
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $table_prescription->links() }}
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection