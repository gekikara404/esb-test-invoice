<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{ $invoice->name }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <style type="text/css" media="screen">
            html {
                font-family: sans-serif;
                line-height: 1.15;
                margin: 0;
            }

            body {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                font-weight: 400;
                line-height: 1.5;
                color: #212529;
                text-align: left;
                background-color: #fff;
                font-size: 10px;
                margin: 36pt;
            }

            h4 {
                margin-top: 0;
                margin-bottom: 0.5rem;
            }

            p {
                margin-top: 0;
                margin-bottom: 1rem;
            }

            strong {
                font-weight: bolder;
            }

            img {
                vertical-align: middle;
                border-style: none;
            }

            table {
                border-collapse: collapse;
            }

            th {
                text-align: inherit;
            }

            h4, .h4 {
                margin-bottom: 0.5rem;
                font-weight: 500;
                line-height: 1.2;
            }

            h4, .h4 {
                font-size: 1.5rem;
            }

            .table {
                width: 100%;
                margin-bottom: 1rem;
                color: #212529;
            }

            .table th,
            .table td {
                padding: 0.75rem;
                vertical-align: top;
            }

            .table.table-items td {
                border-top: 1px solid #dee2e6;
            }

            .table thead th {
                vertical-align: bottom;
                border-bottom: 2px solid #dee2e6;
            }

            .mt-5 {
                margin-top: 3rem !important;
            }

            .pr-0,
            .px-0 {
                padding-right: 0 !important;
            }

            .pl-0,
            .px-0 {
                padding-left: 0 !important;
            }

            .text-right {
                text-align: right !important;
            }

            .text-center {
                text-align: center !important;
            }

            .text-uppercase {
                text-transform: uppercase !important;
            }
            * {
                font-family: "DejaVu Sans";
            }
            body, h1, h2, h3, h4, h5, h6, table, th, tr, td, p, div {
                line-height: 1.1;
            }
            .party-header {
                font-size: 1.5rem;
                font-weight: 400;
            }
            .total-amount {
                font-size: 12px;
                font-weight: 700;
            }
            .border-0 {
                border: none !important;
            }
            .cool-gray {
                color: green;
            }
            .stamp {
                font-size: 3em; /* sets the font size to 3em (h1 size) */
                color: green; /* sets the text color to green */
                transform: rotate(-10deg);
                border: 4px solid green; /* adds a 2px wide solid green border */
                padding:5px;
                display: inline-block;
            }
            .stampUnpaid{
                font-size: 3em; /* sets the font size to 3em (h1 size) */
                color: red; /* sets the text color to green */
                transform: rotate(-10deg);
                border: 4px solid red; /* adds a 2px wide solid green border */
                padding:5px;
                display: inline-block;
            }


        </style>
    </head>

    <body>
        {{-- Header --}}
        @if($invoice->logo)
            <img src="{{ $invoice->getLogo() }}" alt="logo" height="100">
        @endif

        <table class="table mt-5">
            <tbody>
                <tr>
                    <td class="border-0 pl-0" width="40%">
                        <h1 class="text-uppercase">
                            <strong>Invoice</strong>
                        </h1>
                            <p>Invoice No: <strong>{{ $invoice->buyer->digits }}</strong></p>
                            <p>Issued Date: <strong>{{ $invoice->getDate() }}</strong></p>
                            <p>Invoice Date: <strong>{{ $invoice->getDate() }}</strong></p>
                            <p>
                                Subject: {{ $invoice->name }}
                            </p>
                    </td>
                    <td class="border-0 pl-0" width="30%">
                        @if($invoice->status === 'Paid') 
                            <div class="stamp">PAID</div>
                        @else
                            <div class="stampUnpaid">UNPAID</div>
                        @endif
                    </td>
                    <td class="px-0">
                        <h3>From</h3>
                        @if($invoice->seller->name)
                            <p class="seller-name">
                                <strong>{{ $invoice->seller->name }}</strong>
                            </p>
                        @endif

                        @if($invoice->seller->address)
                            <p class="seller-address">
                                {{ __('invoices::invoice.address') }}: {{ $invoice->seller->address }}
                            </p>
                        @endif

                        @if($invoice->seller->phone)
                            <p class="seller-phone">
                                {{ __('invoices::invoice.phone') }}: {{ $invoice->seller->phone }}
                            </p>
                        @endif

                        @foreach($invoice->seller->custom_fields as $key => $value)
                            <p class="seller-custom-field">
                                {{ ucfirst($key) }}: {{ $value }}
                            </p>
                        @endforeach


                        <hr />
                        
                        <h3>To</h3>
                        
                        @if($invoice->buyer->name)
                            <p class="buyer-name">
                                <strong>{{ $invoice->buyer->name }}</strong>
                            </p>
                        @endif

                        @if($invoice->buyer->address)
                            <p class="buyer-address">
                                {{ __('invoices::invoice.address') }}: {{ $invoice->buyer->address }}
                            </p>
                        @endif

                        @if($invoice->buyer->code)
                            <p class="buyer-code">
                                {{ __('invoices::invoice.code') }}: {{ $invoice->buyer->code }}
                            </p>
                        @endif

                        @if($invoice->buyer->vat)
                            <p class="buyer-vat">
                                {{ __('invoices::invoice.vat') }}: {{ $invoice->buyer->vat }}
                            </p>
                        @endif

                        @if($invoice->buyer->phone)
                            <p class="buyer-phone">
                                {{ __('invoices::invoice.phone') }}: {{ $invoice->buyer->phone }}
                            </p>
                        @endif

                        @foreach($invoice->buyer->custom_fields as $key => $value)
                            <p class="buyer-custom-field">
                                {{ ucfirst($key) }}: {{ $value }}
                            </p>
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- Table --}}
        <table class="table table-items">
            <thead>
                <tr>
                    <th scope="col" class="border-0 pl-0">Item Type</th>
                    <th scope="col" class="border-0 pl-0">{{ __('invoices::invoice.description') }}</th>
                    <th scope="col" class="text-right border-0">Quantity</th>
                    <th scope="col" class="text-right border-0">Unit Price</th>
                    <th scope="col" class="text-right border-0 pr-0">Amount</th>
                </tr>
            </thead>
            <tbody>
                {{-- Items --}}
                @foreach($invoice->items as $item)
                <tr>
                    <td class="pl-0">
                        <p>{{ $item->description }}</p>
                    </td>
                    <td class="pl-0">
                        {{ $item->title }}
                    </td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">
                        {{ $invoice->formatCurrency($item->price_per_unit) }}
                    </td>
                    <td class="text-right pr-0">
                        {{ $invoice->formatCurrency($item->sub_total_price) }}
                    </td>
                </tr>
                @endforeach
                {{-- Summary --}}
                @if($invoice->taxable_amount)
                    <tr>
                        <td colspan="{{ $invoice->table_columns - 1 }}" class="border-0"></td>
                        <td class="text-right pl-0">Subtotal</td>
                        <td class="text-right pr-0">
                            {{ $invoice->formatCurrency($invoice->taxable_amount) }}
                        </td>
                    </tr>
                @endif
                @if($invoice->tax_rate)
                    <tr>
                        <td colspan="{{ $invoice->table_columns - 1 }}" class="border-0"></td>
                        <td class="text-right pl-0">{{ __('invoices::invoice.tax_rate') }}</td>
                        <td class="text-right pr-0">
                            {{ $invoice->tax_rate }}%
                        </td>
                    </tr>
                @endif
                @if($invoice->hasItemOrInvoiceTax())
                    <tr>
                        <td colspan="{{ $invoice->table_columns - 1 }}" class="border-0"></td>
                        <td class="text-right pl-0">{{ __('invoices::invoice.total_taxes') }}</td>
                        <td class="text-right pr-0">
                            {{ $invoice->formatCurrency($invoice->total_taxes) }}
                        </td>
                    </tr>
                @endif
                    <tr>
                        <td colspan="{{ $invoice->table_columns - 1 }}" class="border-0"></td>
                        <td class="text-right pl-0">{{ __('invoices::invoice.total_amount') }}</td>
                        <td class="text-right pr-0 total-amount">
                            {{ $invoice->formatCurrency($invoice->total_amount) }}
                        </td>
                    </tr>
            </tbody>
        </table>

        @if($invoice->notes)
            <p>
                {{ trans('invoices::invoice.notes') }}: {!! $invoice->notes !!}
            </p>
        @endif
        @if($invoice->status !== 'Paid')
        <p>
            {{ trans('invoices::invoice.pay_until') }}: {{ $invoice->getPayUntilDate() }}
        </p>
        @endif

        <script type="text/php">
            if (isset($pdf) && $PAGE_COUNT > 1) {
                $text = "Page {PAGE_NUM} / {PAGE_COUNT}";
                $size = 10;
                $font = $fontMetrics->getFont("Verdana");
                $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
                $x = ($pdf->get_width() - $width);
                $y = $pdf->get_height() - 35;
                $pdf->page_text($x, $y, $text, $font, $size);
            }
        </script>
    </body>
</html>
