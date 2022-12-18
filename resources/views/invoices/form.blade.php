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
                            <div class="mb-3">
                                <label class="form-label">Subject</label>
                                <input id="subject" name="subject" type="text" class="form-control form-control-lg" value="{{ isset($data->subject) ? $data->subject : "" }}" required/>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Client</label>
                                <select name="client_id" class="form-control form-control-lg form-flexible select2">
                                    @foreach ($clients as $v)
                                        <option value="{{ $v->id }}"{{ isset($data->client_id) && $data->client_id == $v->id ? " selected=selected" : "" }}>{{ $v->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Issue Date</label>
                                <input id="issued_at" name="issued_at" type="date" class="form-control form-control-lg" value="{{ isset($data->issued_at) ? date('Y-m-d', strtotime($data->issued_at)) : date('Y-m-d') }}" required/>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Due Date</label>
                                <input id="due_date" name="due_date" type="date" class="form-control form-control-lg" value="{{ isset($data->due_date) ? date('Y-m-d', strtotime($data->due_date)) : "" }}" required/>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control form-control-lg form-flexible select2">
                                    @foreach ($statusArr as $k => $v)
                                        <option value="{{ $k }}"{{ isset($data->status) && $data->status == $k ? " selected=selected" : "" }}>{{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="is_using_tax" class="inline-flex items-center">
                                    <input
                                        name="is_using_tax"
                                        type="checkbox"
                                        {{ isset($data->is_using_tax) && $data->is_using_tax == 1 ? " checked" : "" }}
                                    >
                                    <span class="ml-2 text-gray-600">Tax 10% Invoice</span>
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="d-flex d-inline justify-content-end">
                <a href="{{ route('invoices.index') }}" class="btn btn-secondary float-end" style="margin-right: 10px;">Back to Invoice </a>
                <a href="#" id="btn-save" class="btn btn-success float-end" style="margin-right: 10px;">Save</a>
                <a href="{{ url()->previous() }}" class="btn btn-danger float-end" style="margin-left: 5px;">Cancel</a>
            </div>
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
