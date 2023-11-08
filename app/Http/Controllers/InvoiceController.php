<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Payment;

use Dompdf\Dompdf;
use Dompdf\Options; // Import the Options class

class InvoiceController extends Controller
{
    public function index()
    {
        // Fetch a list of invoices from the database
        $invoices = Invoice::all(); // You need to import the Invoice model
    
        return view('invoices.index', compact('invoices'));
    }
    
    public function create()
    {    $customers = Customer::all(); // Fetch the list of customers
        $products = Product::all(); // Fetch the list of customers

        $lastInvoice = Invoice::latest('id')->first();
        $newInvoiceNumber = $lastInvoice ? 'INV-' . str_pad($lastInvoice->id + 1, 5, '0', STR_PAD_LEFT) : 'INV-00001';

        return view('invoices.create', compact('customers', 'products', 'newInvoiceNumber'));
    }
    
    public function store(Request $request)
    {
        $total = 0;

        $itemQuantities = $request->item_quantity;
        $itemPrices = $request->item_price;
    
        foreach ($itemQuantities as $key => $quantity) {
            $price = $itemPrices[$key];
            $subtotal = $quantity * $price;
            $total += $subtotal;
        }
    
        // Store the invoice in the database
        $invoice = new Invoice;
        $invoice->invoice_number = $request->invoice_number;
        $invoice->customer_id = $request->customer_id;
        $invoice->invoice_date = $request->invoice_date;
        $invoice->due_date = $request->due_date; // Add due date to the database
        $invoice->status = 'Unpaid'; // Add due date to the database
        $invoice->total = $total; // Store the calculated total
        $invoice->save();
    
        // Store the invoice items in the database
        foreach ($request->product_id as $key => $product_id) {
            $invoiceItem = new InvoiceItem;
            $invoiceItem->invoice_id = $invoice->id;
            $invoiceItem->product_id = $product_id;
            $invoiceItem->quantity = $itemQuantities[$key];
   
            $invoiceItem->save();
        }
    
        return redirect()->route('invoice.index')->with('success', 'Invoice created successfully.');
    }

    public function edit($id)
{
    $invoice = Invoice::find($id);
    if (!$invoice) {
        return redirect()->route('invoices.index')->with('error', 'Invoice not found');
    }

    $customers = Customer::all();
    $products = Product::all();

    return view('invoices.edit', compact('invoice', 'customers', 'products'));
}

public function update(Request $request, $id)
{
    $invoice = Invoice::find($id);
    if (!$invoice) {
        return redirect()->route('invoices.index')->with('error', 'Invoice not found');
    }

    // Update the invoice data based on the form input
    $invoice->invoice_number = $request->input('invoice_number');
    $invoice->customer_id = $request->input('customer_id');
    $invoice->invoice_date = $request->input('invoice_date');
    // Update other fields as needed

    $invoice->save();

    return redirect()->route('invoice.index')->with('success', 'Invoice updated successfully');
}

public function recordPayment(Request $request, Invoice $invoice)
{
    // Validate the payment data
    $request->validate([
        'amount' => 'required|numeric|min:0',
        'payment_date' => 'required|date',
    ]);

    // Calculate the remaining balance
    $remainingBalance = $invoice->total - $invoice->payments->sum('amount');

    // Check if the payment amount is not more than the remaining balance
    if ($request->input('amount') > $remainingBalance) {
        return redirect()->back()->with('error', 'Payment amount exceeds the remaining balance.');
    }

    // Create a new payment record
    $payment = new Payment([
        'amount' => $request->input('amount'),
        'payment_date' => $request->input('payment_date'),
    ]);

    // Associate the payment with the invoice
    $invoice->payments()->save($payment);

    // Calculate the total paid amount
    $totalPaidAmount = $invoice->payments->sum('amount');

    // Update the invoice status based on the payment amount
    if ($totalPaidAmount >= $invoice->total) {
        $invoice->update(['status' => 'Paid']);
    } else {
        $invoice->update(['status' => 'Partially Paid']);
    }

    return redirect()->back()->with('success', 'Payment recorded successfully.');
}

public function downloadPdf($id)
{
    $invoice = Invoice::find($id);
    if (!$invoice) {
        return redirect()->route('invoices.index')->with('error', 'Invoice not found');
    }

    // Load the view for generating the PDF
    $view = view('pdf.invoice', compact('invoice'));

    // Create PDF with Dompdf
   
    $dompdf = new Dompdf();
    $dompdf->loadHtml($view);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Download the PDF file
    return $dompdf->stream("invoice_{$invoice->invoice_number}.pdf");
}




    
}
