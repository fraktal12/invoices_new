<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">

    <title>Factura - {{$invoice->invoiceNo}}</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <style>
        .text-right {
            text-align: right;
        }
    </style>

</head>
<body class="login-page" style="background: white">

    <div>
        <div class="row">
            <div class="col-xs-7">
                <h4>Vanzator:</h4>
                <strong>Bellatrix Media SRL</strong><br>
                Nr. registru: J40/7768/2018<br>
                Cod fiscal: 39436634<br>
                Cont: RO52INGB0000999908008101<br>
                Aleea Fuiorului 4 Bucuresti Romania - 032173<br>
                T: +40723239457<br>
                E: stefi.radulescu@gmail.com<br><br>
            </div>
            <div class="col-xs-4">
                <img src="{{ storage_path('app/public/logosis.png') }}" alt="logo">
            </div>
        </div>

        <div style="margin-bottom: 0px">&nbsp;</div>

        <div class="row">
            <div class="col-xs-6">
                <h4>Catre:</h4>
                <address>
                    <strong>{{$invoice->client}}</strong><br>
                    <span>Adresa: {{$invoice->clientAddress}}</span><br>
                    <span>CNP/CUI: {{$invoice->clientInfo}}</span> 
                </address>
            </div>
            <div class="col-xs-5">
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <th>Numar factura:</th>
                            <td class="text-right">{{$invoice->invoiceNo}}</td>
                        </tr>
                        <tr>
                            <th> Data emiterii: </th>
                            <td class="text-right">{{$invoice->invoiceDate}}</td>
                        </tr>
                    </tbody>
                </table>

                <div style="margin-bottom: 0px">&nbsp;</div>

                <table style="width: 100%; margin-bottom: 20px">
                    <tbody>
                        <tr class="well" style="padding: 5px">
                            <th style="padding: 5px"><div> Suma de plata </div></th>
                            <td style="padding: 5px" class="text-right"><strong> {{$invoice->grandTotal}} RON</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <table class="table">
            <thead style="background: #F5F5F5;">
                <tr>
                    <th>Produs</th>
                    <th>Cantitate</th>
                    <th>Pret unitar</th>
                    <th class="has-text-right">Total</th>
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

            <div class="row">
                <div class="col-xs-6"></div>
                <div class="col-xs-5">
                    <table style="width: 100%">
                        <tbody>
                            <tr class="well" style="padding: 5px">
                                <th style="padding: 5px"><div> Suma de plata: </div></th>
                                <td style="padding: 5px" class="text-right"><strong> {{$invoice->grandTotal}} RON</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div style="margin-bottom: 0px">&nbsp;</div>

            <div class="row">
                <div class="col-xs-8 invbody-terms">
                    Multumim pentru colaborare! <br>
                    <br>
                    <h4>Termeni si conditii</h4>
                    <p>{{$invoice->termsAndConditions}}</p>
                </div>
            </div>
        </div>

    </body>
</html>