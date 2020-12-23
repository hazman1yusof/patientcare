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
                    <h4 class="card-title">
                    MRN: 8663
                    </h4>   
                    </div>
                     <div class="four wide column">
                    <h4 class="card-title">
                    NAME: NOR LIZAH BINTI YACOB
                    </h4>   
                    </div>
                    <h4 class="card-title">
                    Search:
                    </h4>
                    <div class="four wide column">
                        <input type="text" name="filter_text" class="form-control" placeholder="Please Search..." style="width: 250px" value="{{ $filter_text }}">
                    </div>
                    </form>
                </div>
                <hr/>
                
                <div class="table-responsive">
                    <table class="ui celled striped table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Date</th>
                                <th scope="col">Item Code</th>
                                <th scope="col">Description</th>
                                <th scope="col">Doctor</th>
                                <th scope="col">Dossage Code</th>
                                <th scope="col">Frequency</th>
                                <th scope="col">Instruction</th>
                                <th scope="col">Remark</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Action</th>
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
                                    <td>{{ @$item->date }}</td>
                                    <td>{{ @$item->chgcode }}</td>
                                    <td>{{ @$item->description }}</td>
                                    <td>{{ @$item->doctor }}</td>
                                    <td>{{ @$item->dosecode }}</td>
                                    <td>{{ @$item->freqcode }}</td>
                                    <td>{{ @$item->instcode }}</td>
                                    <td>{{ @$item->remark }}</td>
                                    <td>{{ @$item->qty }}</td>
                                    <td>
                                        <a
                                            href="{{ url('uploads/documents/surat-masuk/') }}"
                                            class="btn btn-sm btn-primary text-white"
                                            target="_blank"
                                        >
                                            <i class="fa fa-bars"></i> View Detail
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