<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceItems;
use Barryvdh\DomPDF\Facade\Pdf;
// This is important to add here. 
use Illuminate\Support\Facades\Session;

class InvoiceController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::all()->sortByDesc('invoiceNo');
        //return view('invoices.index', ['invoices'=>$invoices]);
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $maxInvoiceNo = Invoice::max('invoiceNo');

        return view('invoices.create', compact('maxInvoiceNo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $attributesItems = $request->validate([
            "item"      => "required|array|min:1",
            "item.*"    => "required|string|min:3",
            "unitPrice" => "required|array|min:1",
            "unitPrice.*"  => "required|numeric|min:0",
            "qty"       => "required|array|min:1",
            "qty.*"     => "required|integer||min:1"
        ]);

        // add the id to the attributes passed to invoice_items model:create method
        $insertItemsData = collect();
        // subtotal for the invoice
        $subTotal = 0;

        for ($i = 0; $i < count($attributesItems['item']); $i++) {

            $data = array(
                'item' => $attributesItems['item'][$i],
                'unitPrice' => $attributesItems['unitPrice'][$i],
                'qty' => (int)($attributesItems['qty'][$i])
            );
            // add items to the collection
            $insertItemsData->push(new InvoiceItems($data));

            // update the subtotal
            $subTotal += $attributesItems['unitPrice'][$i] * $attributesItems['qty'][$i];
        }

        // required - used in the server side validation
        $attributes = $request->validate([
            'invoiceNo' => 'required',
            'invoiceDate' => 'required',
            'dueDate' => 'required',
            'title' => 'nullable|max:100',
            'client' => 'required|max:100',
            'clientAddress' => 'required|max:100',
            'clientInfo' => 'required|max:100',
            'status' => 'required',
            'subTotal' => 'required',
            'discount' => 'required|numeric|min:0',
            'grandTotal' => 'required'
        ]);

        $attributes['subTotal'] = $subTotal;

        // insert the invoice data
        $invoice = Invoice::create($attributes);

        // add invoice ID to the invoice items collection
        foreach ($insertItemsData as $data) {
            $data['invoice_id'] = $invoice->id;
            //insert invoice items updated with invoice ID; make the collection element an array
            InvoiceItems::create($data->toArray());
        }
        Session::flash('message', 'Successfully created invoice!');
        // return in the view mode
        return redirect()->route('invoices.show', compact('invoice'));
        //return redirect()->route('invoices.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        return view('invoices.edit', compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        // delete previous entries of this invoice and insert the new ones
        $invoice->invoiceItems()->delete();

        $attributesItems = $request->validate([
            "item"      => "required|array|min:1",
            "item.*"    => "required|string|min:3",
            "unitPrice" => "required|array|min:1",
            "unitPrice.*"  => "required|numeric|min:0",
            "qty"       => "required|array|min:1",
            "qty.*"     => "required|integer||min:1"
        ]);

        // add the id to the attributes passed to invoice_items model:create method
        $insertItemsData = collect();
        // subtotal for the invoice
        $subTotal = 0;

        for ($i = 0; $i < count($attributesItems['item']); $i++) {

            $data = array(
                'item' => $attributesItems['item'][$i],
                'unitPrice' => $attributesItems['unitPrice'][$i],
                'qty' => (int)($attributesItems['qty'][$i]),
                'invoice_id' => $invoice->id
            );
            // add items to the collection
            $insertItemsData->push(new InvoiceItems($data));
        }

        // required - used in the server side validation
        $attributes = $request->validate([
            'invoiceNo' => 'required',
            'invoiceDate' => 'required',
            'dueDate' => 'required',
            'title' => 'nullable|max:100',
            'client' => 'required|max:100',
            'clientAddress' => 'required|max:100',
            'status' => 'required',
            'subTotal' => 'required',
            'discount' => 'required|numeric|min:0',
            'grandTotal' => 'required'
        ]);

        //$attributes['subTotal'] = $subTotal;
        // update the invoice data
        Invoice::whereId($invoice->id)->update($attributes);

        // add invoice ID to the invoice items collection
        foreach ($insertItemsData as $data) {
            //insert invoice items updated with invoice ID; make the collection element an array
            InvoiceItems::create($data->toArray());
        }

        //return view('invoices.show', compact('invoice'));
        return redirect()->route('invoices.show', compact('invoice'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {

        $invoice->invoiceItems()->delete();
        $invoice->delete();

        //return redirect('/invoices');
        return redirect()->route('invoices.index');
    }

    /**
     * @param Request $request
     * @param $invoice
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request, $invoice)
    {
        $invoice = Invoice::findOrFail($invoice);
        $invoice->status = $request->input('status');
        $invoice->save();

        return response()->json(['message' => 'Invoice status updated successfully']);
    }

    /**
     * @param Invoice $invoice
     * @return mixed
     */
    public function printPDF(Invoice $invoice)
    {

        $pdf = PDF::loadView('invoices.pdf', compact('invoice'));
        return $pdf->download('Factura_nr' . $invoice->invoiceNo . '_' . $invoice->client . '.pdf');
    }
}
