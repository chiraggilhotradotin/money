<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    function index()
    {
        $customers = Customer::where(['user_id' => auth()->user()->id, 'isDeleted' => 0])->get();
        return view('customers.index', ['customers' => $customers]);
    }
    function add(Request $request)
    {
        if ($request->isMethod("POST")) {
            $customer = new Customer();
            $customer->name = $request->name;
            $customer_user_id = NULL;
            if ($request->uuid) {
                $user = User::where('uuid', $request->uuid)->first();
                if ($user)
                    $customer_user_id = $user->id;
            }
            $customer->customer_user_id = $customer_user_id;
            $customer->user_id = auth()->user()->id;
            $customer->uuid = Str::orderedUuid();
            if ($request->amount)
                $customer->balance = $request->amount;
            $customer->save();
            if ($request->amount) {
                $transaction = new Transaction();
                $transaction->customer_id = $customer->id;
                $transaction->user_id = auth()->user()->id;
                $transaction->amount = $request->amount;
                $transaction->uuid = Str::orderedUuid();
                $transaction->description = "Opening Balance";
                $transaction->isApproved = 1;
                $transaction->save();
            }
            return redirect()->route("customers.show", $customer->uuid);
        }
        return view('customers.add');
    }
    function show($customer_uuid)
    {
        $customer = Customer::where(['uuid' => $customer_uuid, 'isDeleted' => 0])->firstOrFail();
        $transactions = Transaction::where(['customer_id' => $customer->id, 'isDeleted' => 0])->get();
        return view('transactions.index', ['customer' => $customer, 'transactions' => $transactions]);
    }
    function delete($customer_uuid)
    {
        $customer = Customer::where(['uuid' => $customer_uuid, 'isDeleted' => 0])->firstOrFail();
        $customer->isDeleted = 1;
        $customer->save();
        return redirect()->route('customers');
    }
    function edit(Request $request, $customer_uuid)
    {
        $customer = Customer::where(['uuid' => $customer_uuid, 'isDeleted' => 0])->firstOrFail();
        if ($request->isMethod("POST")) {
            $customer->name = $request->name;
            $customer->save();
            return redirect()->route("customers");
        }
        return view('customers.edit', ['customer' => $customer]);
    }
}
