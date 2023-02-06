<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomersController extends Controller
{

    //Get and return all customer 
    public function index(){

        $customers = Customer::all();

        return view('index',compact('customers'));

    }

    // Get all ajax request and store the record and returns the response

    public function addCustomer(Request $request){

        $customer = new Customer();

        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->address = $request->address;

        $customer->save();

        return response()->json($customer);
    }


    // This method gets the customer by id for edit form

    public function getCustomerById($id)
    {
        $customer = Customer::find($id);
        return response()->json($customer);
    }


    // This method Will update the requested ajax update

    public function updateCustomer(Request $request)
    {
        $customer = Customer::find($request->id);

        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->address = $request->address;

        $customer->save();

        return response()->json($customer);
    }


    // This method will delete the specific record
    
    public function deleteCustomer($id){

        $customer = Customer::find($id);

        $customer->delete();

        return response()->json(['success'=>'Customer has been deleted']);
    }
}