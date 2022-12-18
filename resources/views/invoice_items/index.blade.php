@extends('layout')
@section('content')
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Invoice Items INV-{{ Str::padLeft($invoice->id, config('global.invoice_digits'), 0) }} </h1>
        <a href="{{ route('invoices.invoice_items.create', ['invoice' => $invoice->id]) }}" class="btn btn-primary float-end" style="margin-left: 10px;">Create </a>
        <a href="{{ route('invoices.index') }}" class="btn btn-secondary float-end" style="margin-left: 10px;">Back to Invoice list </a>
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
                                <th scope="col">Item</th>
                                <th scope="col" class="text-right">Qty</th>
                                <th scope="col" class="text-right">Price</th>
                                <th scope="col" class="text-right">Total</th>
                                <th scope="col" width="5%">Action</th>
                                <th scope="col" width="5%">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $v)
                                <tr>
                                    <td>{{ $v->item->name }}</td>
                                    <td class="text-right">{{ $v->qty }}</td>
                                    <td class="text-right">{{ config('global.default_currency_symbol').number_format($v->price,2) }}</td>
                                    <td class="text-right">{{ config('global.default_currency_symbol').number_format($v->price * $v->qty,2) }}</td>
                                    <td>
                                        <a href="{{ route('invoices.invoice_items.edit', ['invoice' => $invoice->id, 'invoice_item' => $v->id]) }}" class="btn btn-warning float-end">Edit</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('invoices.invoice_items.destroy', ['invoice' => $invoice->id, 'invoice_item' => $v->id]) }}" method="POST">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit" class="btn btn-danger float-end">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @include('pagination', ['paginator' => $data])
                </div>
            </div>
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
    $("#searchForm").submit( function(eventObj) {
        let searchParams = new URLSearchParams(window.location.search)
        searchParams.delete("_token");
        searchParams.delete("key");
        searchParams.delete("value");
        searchParams.forEach(function(value, key) {
            $("<input />").attr("type", "hidden")
                .attr("name", key)
                .attr("value", value)
                .appendTo("#searchForm");
        });
        return true;
    });
</script>
@endsection
