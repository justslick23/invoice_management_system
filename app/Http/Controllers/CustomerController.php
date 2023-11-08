<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
{
    $customers = Customer::all();
    return view('customers.index', compact('customers'));
}

public function create()
{
    $pageSlug = 'customer.create'; // Set the appropriate value
    return view('customers.create', compact('pageSlug'));
}

public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required',
        'contact_person' => 'required',
        'email' => 'required|email',
        'address' => 'required',
        'phone' => 'required',
        // Add validation rules for other fields as needed
    ]);

    Customer::create($validatedData);

    return redirect('/customers')->with('success', 'Customer created successfully.');
}

public function edit($id)
{
    $customer = Customer::find($id);
    return view('customers.edit', compact('customer'));
}

public function update(Request $request, $id)
{
    $customer = Customer::find($id);
    $customer->update($request->all());

    return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
}

public function destroy($id)
{
    $customer = Customer::find($id);
    $customer->delete();

    return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
}




}
