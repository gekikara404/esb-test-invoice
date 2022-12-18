@extends('layout')
@section('content')
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">{{ $label }}</h1>
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
                    <form
                        action="{{ $formActionURL }}"
                        method="POST"
                        enctype="multipart/form-data"
                        id="form-firm"
                    >
                        @if ($method == 'edit')
                            <input type="hidden" name="_method" value="PUT" />
                        @endif
                        @csrf
                        <div class="card card-body">
                            <input type="hidden" name="invoice_id" value="{{ $invoice->id }}" />
                            <div class="mb-3">
                                <label class="form-label">Item</label>
                                <select name="item_id" class="form-control form-control-lg form-flexible select2">
                                    @foreach ($items as $v)
                                        <option value="{{ $v->id }}"{{ isset($data->item_id) && $data->item_id == $v->id ? " selected=selected" : "" }}>{{ $v->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Price</label>
                                <div class="input-group">
                                    <input id="price" name="price" type="number" class="form-control form-control-lg" value="{{ isset($data->price) ? $data->price : 0 }}" required/>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Qty</label>
                                <input id="qty" name="qty" type="number" class="form-control form-control-lg" value="{{ isset($data->qty) ? $data->qty : 0 }}" required/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="d-flex d-inline justify-content-end">
            <a href="{{ route('invoices.invoice_items.index', ['invoice' => $invoice->id]) }}" class="btn btn-secondary float-end" style="margin-right: 10px;">Back to Invoice list </a>
            <a href="#" id="btn-save" class="btn btn-success float-end" style="margin-right: 10px;">Save</a>
            <a href="{{ url()->previous() }}" class="btn btn-danger float-end" style="margin-left: 5px;">Cancel</a>
        </div>
    </div>
@endsection

@section('style')
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
<style>
.title-link h1 {
    color: blue;
}
.text-left {
  text-align: left !important;
}
</style>
@endsection

@section('script')
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script>
    $('#btn-save').click( function(e) {
        e.preventDefault();
        $('form#form-firm').submit();
    });
</script>
@endsection
