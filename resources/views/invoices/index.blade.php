@extends('layout')
@section('content')
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Invoices</h1>
        <a href="{{ route('invoices.create') }}" class="btn btn-primary float-end" style="margin-left: 10px;">Create Invoice </a>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Invoice No</th>
                                <th scope="col">Client</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Status</th>
                                <th scope="col">Due Date</th>
                                <th scope="col" class="text-right">Total</th>
                                <th scope="col" width="5%">&nbsp;</th>
                                <th scope="col" width="5%">Action</th>
                                <th scope="col" width="5%">&nbsp;</th>
                                <th scope="col" width="5%">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $v)
                                <tr>
                                    <td>{{ Str::padLeft($v->id, config('global.invoice_digits'), 0) }}</td>
                                    <td>{{ $v->client->name }}</td>
                                    <td>{{ $v->subject }}</td>
                                    <td>{{ $v->status ? 'PAID' : 'UNPAID' }}</td>
                                    <td>{{ date('d/m/Y', strtotime($v->due_date)) }}</td>
                                    @php $total = 0; @endphp
                                    @foreach ($v->invoice_items as $x)
                                        @php $total += $x->price * $x->qty; @endphp
                                    @endforeach
                                    @if ($v->is_using_tax)
                                        @php $total += $total * config('global.tax_percentage')/100; @endphp
                                    @endif
                                    <td class="text-right">{{ config('global.default_currency_symbol').number_format($total,2) }}</td>
                                    <td>
                                        <a href="{{ route('invoices.edit', ['invoice' => $v->id]) }}" class="btn btn-warning float-end">Edit</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('invoices.destroy', $v->id) }}" method="POST">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit" class="btn btn-danger float-end">Delete</button>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="{{ route('invoices.invoice_items.index', ['invoice' => $v->id]) }}" class="btn btn-success float-end">Items</a> 
                                    </td>
                                    <td>
                                        <a target="_blank" href="{{ route('invoices.print', ['invoice' => $v->id]) }}" class="btn btn-outline btn-outline-primary float-end">Print</a> 
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @include('pagination', ['paginator' => $data])
                </div>
            </div>
            <h1 >List API</h1><br/>
            <ol>
                <li style="margin-bottom: 10px;">
                    <a target="_blank" href="{{ url('api/data/') }}" class="btn btn-primary" style="margin-left: 10px;">Get All Invoice </a>
                </li>
                @php
                    $invoice = App\Models\Invoice::first();
                    $invoice_id = $invoice ? $invoice->id : null;
                @endphp
                <li>
                    <a target="_blank" href="{{ url('api/data/'.$invoice_id) }}" class="btn btn-primary" style="margin-left: 10px;">Get Invoice with ID Invoice {{ $invoice_id }}</a>
                </li>
            </ol>
        </div>
    </div>
@endsection

@section('style')
<style>
.title-link h1 {
    color: blue;
}
.text-right {
    text-align: right;
}
</style>
@endsection

@section('script')
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script>
    $('#select-page').change(function(e){
        if (this.value != null && this.value != "") {
            let searchParams = new URLSearchParams(window.location.search)
            searchParams.delete('per_page');
            searchParams.append('per_page', this.value);
            window.location='{{ route('invoices.index') }}?'+searchParams.toString();
        }
    });
</script>
@endsection
