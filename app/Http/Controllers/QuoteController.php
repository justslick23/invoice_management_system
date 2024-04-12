<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\Customer;
use App\Models\Product;

class QuoteController extends Controller
{

    public function index()
    {
        // Fetch a list of invoices from the database
        $quotes = Quote::all(); // You need to import the Invoice model
    
        return view('quote.index', compact('quotes'));
    }
    public function create()
    {
        $customers = Customer::all(); // Fetch the list of customers
        $products = Product::all(); // Fetch the list of products
    
        $lastQuote = Quote::latest('id')->first();
    
        // Get the current year and month
        $yearMonth = date('Ym');
    
        // If there is no last quote, set the sequential number to 1
        $sequentialNumber = 1;
    
        if ($lastQuote) {
            // Extract the year and month from the last quote number
            $lastYearMonth = substr($lastQuote->quote_number, 4, 6);
    
            if ($lastYearMonth == $yearMonth) {
                // If the last quote is from the same month, increment the sequential number
                $sequentialNumber = intval(substr($lastQuote->quote_number, -5)) + 1;
            }
        }
    
        // Format the sequential number with leading zeros
        $formattedSequentialNumber = str_pad($sequentialNumber, 4, '0', STR_PAD_LEFT);
    
        // Construct the new quote number
        $newQuoteNumber = 'QUO-' . $yearMonth . '-' . $formattedSequentialNumber;
    
        return view('quote.create', compact('customers', 'products', 'newQuoteNumber'));
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
        $quote = new Quote;
        $quote->quote_number = $request->invoice_number;
        $quote->customer_id = $request->customer_id;
        $quote->quote_date = $request->quote_date;
        $quote->expiration_date = $request->expiration_date; // Add due date to the database
        $quote->total = $total; // Store the calculated total
        $quote->save();
    
        // Store the invoice items in the database
        foreach ($request->product_id as $key => $product_id) {
            $quoteItem = new QuoteItem;
            $quoteItem->quote_id = $quote->id;
            $quoteItem->product_id = $product_id;
            $quoteItem->quantity = $itemQuantities[$key];
   
            $quoteItem->save();
        }
    
        return redirect()->route('quote.index')->with('success', 'Quote created successfully.');
    }
}
