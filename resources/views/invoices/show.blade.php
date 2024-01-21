@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="columns">
            <div class="column">
                <h3 class="title">
                    Vizualizare factura nr - {{$invoice->invoiceNo}}
                </h3>
            </div>
            <div class="column">
                <!-- Right side -->
                <div class="field is-grouped is-pulled-right">
                    <p class="control">
                        <a class="button is-primary is-outlined" href="{{route('invoices.index')}}" style="text-decoration: none" >Inapoi la Dashboard</a>
                    </p>
                    <p class="control">
                        <a class="button is-link is-outlined" href="{{$invoice->id}}/edit" style="text-decoration: none">Editeaza</a>
                    </p>
                    <p class="control">
                        <a class="button is-info is-outlined" href="{{$invoice->id}}/pdf" style="text-decoration: none">PDF</a>
                    </p>
                    <form method="POST" action="{{$invoice->id}}">
                        @csrf
                        @method('DELETE')
                        <div class="control">
                            <button  class="button is-danger is-outlined">Sterge</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <hr class="navbar-divider">
    <div class="container ">
        <div class="level is-small">
            <div class="level-left">
                <div class = "level-item is-pulled-left"> Catre: {{$invoice->client}}</div>
            </div>
            <div class="level-right ">
                <div class = "level-item is-pulled-right">Numar: {{$invoice->invoiceNo}}</div>
            </div>
        </div>
        <div class="level">
            <div class="level-left">
                <div class = "level-item is-pulled-left">{{$invoice->clientAddress}}</div>
            </div>
            <div class="level-right ">
                <div class = "level-item is-pulled-right">Data: {{$invoice->invoiceDate}}</div>
            </div>
        </div>
        <div class="level">
            <div class="level-left">
                <div class = "level-item is-pulled-left">CNP/CUI: {{$invoice->clientInfo}}</div>
            </div>
            <div class="level-right ">
                <div class = "level-item is-pulled-right">Data limita: {{$invoice->dueDate}}</div>
            </div>
        </div>
        <div class="level">
            <div class="level-left">
                <div class = "level-item is-pulled-left">Referinta: {{$invoice->title}}</div>
            </div>
            <div class="level-right ">
                <div class = "level-item is-pulled-right">Stare: {{$invoice->status}}</div>
            </div>
        </div>
    </div>
    <br>
    <div class="container">
        <table class="table table is-striped is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th><abbr title="Item name">Produs</abbr></th>
                    <th><abbr title="Quantity">Cantitate</abbr></th>
                    <th><abbr title="Item price">Pret unitar</th>
                    <th class = "has-text-right"><abbr title="Subtotal">Total</abbr></th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < count($invoice->invoiceItems->pluck('item')); $i++)
                    <tr>
                        <td>{{$invoice->invoiceItems->pluck('item')[$i]}}</td>
                        <td>{{$invoice->invoiceItems->pluck('qty')[$i]}}</td>
                        <td>{{$invoice->invoiceItems->pluck('unitPrice')[$i]}} RON</td>
                        <td class = "has-text-right">{{$invoice->invoiceItems->pluck('qty')[$i] * $invoice->invoiceItems->pluck('unitPrice')[$i]}} RON</td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
    <div class="container">
        <div class="level">
            <div class="level-left">
                <div class = "level-item is-pulled-left"></div>
            </div>
            <div class="level-right ">
                <div class = "level-item is-pulled-right has-text-weight-bold">Subtotal: {{$invoice->subTotal}} RON</div>
            </div>
        </div>
        <div class="level">
            <div class="level-left">
                <div class = "level-item is-pulled-left"></div>
            </div>
            <div class="level-right ">
                <div class = "level-item is-pulled-right has-text-weight-bold">Discount: {{$invoice->discount}} %</div>
            </div>
        </div>
        <div class="level">
            <div class="level-left">
                <div class = "level-item is-pulled-left"></div>
            </div>
            <div class="level-right ">
                <div class = "level-item is-pulled-right has-text-weight-bold">Grand Total: {{$invoice->grandTotal}} RON</div>
            </div>
        </div>
        <div class="level">
            <article class="message is-primary is-small">
                <div class="message-body">
                    {{$invoice->termsAndConditions == null ? 'Termeni si conditii' : $invoice->termsAndConditions}}
                </div>
              </article>
        </div>
    </div>
@endsection