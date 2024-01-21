<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItems extends Model
{
    protected $fillable = ['invoice_id', 'item', 'qty', 'unitPrice'];
    //protected $guarded = [];
    //public $timestamps = true;
    /**
     * Get the items for the invoice.
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
