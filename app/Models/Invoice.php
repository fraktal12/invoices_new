<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model

{
    protected $fillable = ['invoiceNo', 'invoiceDate', 'dueDate', 'status', 'title', 'client', 'clientAddress', 'clientInfo', 'subTotal', 'discount', 'grandTotal', 'termsAndConditions'];
    /**
     * Get the items for the invoice.
     */
    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItems::class);
    }
}
