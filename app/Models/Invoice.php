<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use PDF;
class Invoice extends Model
{
    use HasFactory;

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function generatePdf()
    {
        // Render the invoice data into a Blade view
        $pdfContent = PDF::loadView('pdf.invoice', ['invoice' => $this])->output();

        return $pdfContent;
    }
}
