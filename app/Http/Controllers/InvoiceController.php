<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Payment;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceEmail;

use PDF; // Import the Options class

class InvoiceController extends Controller
{
    public function index()
    {
        // Fetch a list of invoices from the database
        $invoices = Invoice::all();
        foreach ($invoices as $invoice) {
            $recipientEmail = $invoice->customer->email; // Access the customer's email associated with each invoice
            // Now you can use $recipientEmail as needed
        } // You need to import the Invoice model
    
        return view('invoices.index', compact('invoices', 'recipientEmail'));
    }
    
    public function create()
    {
        $customers = Customer::all(); // Fetch the list of customers
        $products = Product::all(); // Fetch the list of products
    
        $lastInvoice = Invoice::latest('id')->first();
    
        // Get the current year and month
        $yearMonth = date('Ym');
    
        // If there is no last invoice, set the sequential number to 1
        $sequentialNumber = 1;
    
        if ($lastInvoice) {
            // Extract the year and month from the last invoice number
            $lastYearMonth = substr($lastInvoice->invoice_number, 4, 6);
    
            if ($lastYearMonth == $yearMonth) {
                // If the last invoice is from the same month, increment the sequential number
                $sequentialNumber = intval(substr($lastInvoice->invoice_number, -5)) + 1;
            }
        }
    
        // Format the sequential number with leading zeros
        $formattedSequentialNumber = str_pad($sequentialNumber, 4, '0', STR_PAD_LEFT);
    
        // Construct the new invoice number
        $newInvoiceNumber = 'INV-' . $yearMonth . '-' . $formattedSequentialNumber;
    
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

    // Use the Google Fonts URL for Montserrat as an example
    $fontUrl = 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400&display=swap';

    $data = [
        'invoice' => $invoice, // Replace with your actual data
        'fontUrl' => $fontUrl,
    ];

    $pdf = PDF::loadView('pdf.invoice', $data);

    // Download the PDF file
    return $pdf->stream("invoice_{$invoice->invoice_number}.pdf");
}

public function sendInvoiceEmail($invoiceId, $recipientEmail)
{
    // Find the invoice by ID
    $invoice = Invoice::findOrFail($invoiceId);

    // Generate PDF from Blade template
    $pdf = PDF::loadView('pdf.invoice', ['invoice' => $invoice]);
    $pdf->setPaper('A4');
    
    // Get the PDF content as a string
    $pdfContent = $pdf->output();

    // Save the PDF to a temporary location
    $tempPdfPath = storage_path('app/temp/invoice.pdf');
    file_put_contents($tempPdfPath, $pdfContent);

    // Send email with attached PDF
    $mailSent = Mail::to($recipientEmail)->send(new InvoiceEmail($invoice, $tempPdfPath));
    
    // Delete the temporary PDF file after sending the email
    unlink($tempPdfPath);

    if ($mailSent) {
        // If email was sent successfully, return a success message
        return redirect()->back()->with('success', 'Invoice email sent successfully!');
    } else {
        // If email sending failed, return an error message
        return redirect()->back()->with('error', 'Failed to send invoice email.');
    }
}






    
}
