@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="columns">
            <div class="column">
                <h2 class="title">
                        Sumar facturi - Bellatrix Media SRL
                </h2>
            </div>
            <div class="column">
                <!-- Right side -->
                <div class="level-right">
                    <p class="level-item"><a href="{{route('invoices.create')}}" style="text-decoration: none" class="button is-primary">Factura noua</a></p>
                </div>
            </div>
        </div>
        <table id="invoices-table" class="table">
            <thead>
                <tr>
                    <th>Factura</th>
                    <th>Client</th>
                    <th>Stare</th>
                    <th>Data facturii</th>
                    <th>Total</th>
                    <th>Actiuni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices  as $invoice)
                    <tr>
                        <td>
                            <a href="{{route('invoices.show',[$invoice->id])}}">
                                {{$invoice->invoiceNo}}
                            </a>
                        </td>
                        <td>
                            {{$invoice->client}}
                        </td>
                        <td class="statusInvoice">
                            {{$invoice->status}}
                        </td>
                        <td>
                            {{$invoice->invoiceDate}}
                        </td>
                        <td>
                            {{$invoice->grandTotal}} RON
                        </td>
                        <td>
                            <a href="{{route('invoices.show',[$invoice->id])}}" style="text-decoration: none" class="button is-small is-link is-outlined">Vezi</a>
                            <a href="" style="text-decoration: none" class="button is-small {{ $invoice->status == 'unpaid' ? 'is-danger' : 'is-success' }} is-outlined updateStatus" data-invoice-id="{{$invoice->id}}">{{ $invoice->status == 'unpaid' ? 'Neplatit' : 'Platit' }}</a>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('scripts')
    <script>
        $(function() {
            $('#invoices-table').DataTable();

            $('.updateStatus').on('click', function(event) {
                event.preventDefault();

                //var invoiceId = $(this).data('invoice-id');
                var invoiceId = $(this).attr('data-invoice-id');

                var currentStatus = $(this).text().trim() === 'Neplatit' ? 'unpaid' : 'paid';
                var newStatus = currentStatus === 'unpaid' ? 'paid' : 'unpaid';

                // Make an AJAX request to update the invoice status
                $.ajax({
                    url: 'invoices/' + invoiceId + '/status',
                    type: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: JSON.stringify({
                        status: newStatus
                    }),
                    success: function(response) {

                        //console.log(response);
                        // Update the button text and class based on the new status
                        var button = $('.updateStatus[data-invoice-id="' + invoiceId + '"]');
                        button.text(newStatus === 'unpaid' ? 'Neplatit' : 'Platit');
                        button.removeClass('is-danger is-success').addClass(newStatus === 'unpaid' ? 'is-danger' : 'is-success');
                        button.closest('tr').find('.statusInvoice').text(newStatus);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
@endsection
