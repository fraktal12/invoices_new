@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="columns">
            <div class="column">
                <h3 class="title">
                    Factură nouă
                </h3>
            </div>
            <div class="column">
                <!-- Right side -->
                <div class="level-right">
                    <p class="level-item"><a href="{{route('invoices.index')}}" style="text-decoration: none" class="button is-link is-outlined">Inapoi la Dashboard</a></p>
                </div>
            </div>
        </div>
        <form action="/invoices" method="POST">
            @csrf
            <div class="columns">
                <div class="column">
                    <div class="field">
                    <label class="label">Factura Nr</label>
                        <div class="control">
                            <input class="input is-small" type="text" value = {{$maxInvoiceNo+1}}  name = "invoiceNo" readonly>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label">Client</label>
                        <div class="control">
                            <input class="input is-small" type="text" value = "{{old('client')}}" name = "client" placeholder="Client" required>
                        </div>
                    </div>
                </div>               
                <div class="column">
                    <div class="field">
                        <label class="label">Adresa client</label>
                        <div class="control">
                            <input class="input is-small" type="text" name = "clientAddress" value = "{{old('clientAddress')}}" placeholder="Client Address" required>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label">CNP/CUI</label>
                        <div class="control">
                            <input class="input is-small" type="text" name = "clientInfo" value = "{{old('clientInfo')}}" placeholder="Client CNP/CUI" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label class="label">Referinta</label>
                        <div class="control">
                            <input class="input is-small" type="text" value = "Servicii foto" name = "title" placeholder="Referinta">
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label">Data facturii</label>
                        <div class="control">
                            <input class="input is-small" type="date" value = "{{old('invoiceDate')}}" name = "invoiceDate" placeholder="Data facturii" required>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label">Data limita de plata</label>
                        <div class="control">
                            <input class="input is-small" type="date" value = "{{old('dueDate')}}" name = "dueDate" placeholder="Data limita de plata" required>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label">Stare</label>
                        <div class="select is-small"  required>
                            <select name = "status" id="status">
                                <option value = "unpaid" selected>Neplatita</option>
                                <option value = "paid">Platita</option>
                                <option value = "cancelled">Anulata</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns itemsRow is-vcentered">
                <div class="column">
                    <div class="field">
                        <label class="label">Descriere produs/serviciu</label>
                        <div class="control">
                            <input class="input is-small" type="text" value = "Servicii foto" name = "item[]" placeholder="Descriere produs/serviciu" required>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label">Pret unitar</label>
                        <div class="control">
                            <input class="input is-small" type="number" value = "{{old('unitPrice')}}" name = "unitPrice[]" placeholder="Pret unitar" min="0" required>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label">Cantitate</label>
                        <div class="control">
                            <input class="input is-small" type="number" value = "1" name = "qty[]" placeholder="Cantitate" min="1" required>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label">Total</label>
                        <div class="control">
                            <input class="input is-small" type="number" value = "" name = "total[]" placeholder="" readonly >
                        </div>
                    </div>
                </div>
                <div class="column is-1 text-center">
                    <a class="button is-danger is-outlined is-small" disabled>
                        <span class="icon is-small">
                            <i class="fas fa-times"></i>
                        </span>
                    </a>
                </div>
            </div>
            <div class="columns">
                <div class="column is-2">
                    <!-- left side -->
                    <div class="field is-pulled-left">
                        <p class="control">
                            <a id = "addRow" class="button is-primary is-outlined is-small" style="text-decoration: none">Rand nou</a>
                        </p>
                    </div>
                </div>
                <div class="column is-4 is-offset-6">
                    <div class="field is-horizontal">
                        <div class="field-label">
                            <label class="label">Subtotal</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control">
                                    <input class="input is-small" type="number" name = "subTotal" placeholder="Subtotal" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-4 is-offset-8">
                    <div class="field is-horizontal">
                        <div class="field-label">
                            <label class="label">Discount (%)</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control">
                                    <input class="input is-small" type="number" value = "0" name = "discount" placeholder="Discount" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-4">
                    <div class="field is-horizontal">
                        <div class="field-label">
                            <label class="label">Termeni si Conditii</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control">
                                    <textarea class="input is-small" name = "termsAndConditions" rows="4" placeholder="Termeni si Conditii"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-4 is-offset-4">
                    <div class="field is-horizontal">
                        <div class="field-label">
                            <label class="label">Grand Total</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control">
                                    <input class="input is-small" type="number" name = "grandTotal" placeholder="Total" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field is-grouped">
                <div class="control">
                    {{-- <button class="button is-link">Save</button> --}}
                    <input type="submit" class="button is-link" value="Salveaza" />
                </div>
                <div class="control">
                    <a class="button" href="{{url()->previous()}}" style="text-decoration: none">Anuleaza</a>
                </div>
            </div>
            @include ('invoices.errors')
        </form>

    </div>
@endsection
@section('script')
    <script>
        $( document ).ready(function() {

            function updatePrice() {

                let total;
                let price;
                let qty;

                if (this.name === 'unitPrice[]'){
                    price = $( this ).val();
                }
                else{
                    price = $( this ).closest('.itemsRow').find('input[name="unitPrice[]"]').val();
                }

                if (this.name === 'qty[]'){
                    qty = $( this ).val();
                }
                else{
                    qty = $( this ).closest('.itemsRow').find('input[name="qty[]"]').val();
                }

                total = price* qty;

                $( this ).closest('.itemsRow').find('input[name="total[]"]').val(total);

                updateSubtotal();

            }

            function updateSubtotal() {

                let subTotal = 0;

                $( ".itemsRow" ).each(function() {
                    let rowTotal = $( this ).find('input[name="total[]"]').val();
                    subTotal += (+rowTotal);    // unary operator
                    $('input[name="subTotal"]').val(subTotal);
                });

                updateGrandTotal();

            }

            function updateGrandTotal() {

                let grandTotal = 0;

                let subTotal = $('input[name="subTotal"]').val();
                let discount = $('input[name="discount"]').val();

                grandTotal = (+subTotal) - (+discount)*(+subTotal)/100;

                $('input[name="grandTotal"]').val(grandTotal);

            }

            $(document).on('click', '#addRow', function () {

                let clonedRow = $(".itemsRow:last").clone();
                
                clonedRow.find('input').val('');
                clonedRow.find('.is-danger').removeAttr('disabled');
                $(".itemsRow:last").after(clonedRow);

            });

            $(document).on('click', '.is-danger:not([disabled])', function () {
                $(this).closest(".itemsRow").remove();
                updateSubtotal();
            });

            $(document).on("keyup change mouseup", "input[name='qty[]'], input[name='unitPrice[]']", updatePrice);
            $(document).on("keyup change mouseup", "input[name='discount']", updateGrandTotal);
        });
    </script>
@stop
