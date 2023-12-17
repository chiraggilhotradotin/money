<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    function add(Request $request, $customer_uuid)
    {
        if ($request->isMethod("POST")) {
            $customer = Customer::where('uuid', $customer_uuid)->firstOrFail();
            $transaction = new Transaction();
            if ($customer->user_id == auth()->user()->id) {
                $transaction->isApproved = 1;
                $customer->balance = $customer->balance + $request->amount;
                $customer->save();
            }
            $transaction->customer_id = $customer->id;
            $transaction->user_id = auth()->user()->id;
            $transaction->amount = $request->amount;
            $transaction->uuid = Str::orderedUuid();
            $transaction->description = $request->description;
            $transaction->save();
            return redirect()->route("customers.show", $customer->uuid);
        }
        return view('transactions.add');
    }
    function edit(Request $request, $customer_uuid, $transaction_uuid)
    {
        $transaction = Transaction::where(['uuid' => $transaction_uuid, 'isDeleted' => 0])->firstOrFail();
        $customer = Customer::where(['uuid' => $customer_uuid, 'isDeleted' => 0])->firstOrFail();
        if ($request->isMethod("POST")) {
            $changed_amount = $customer->amount - $request->amount;
            $transaction->amount = $request->amount;
            $transaction->description = $request->description;
            $transaction->save();
            if ($transaction->isApproved == 1) {
                $customer->balance = -$changed_amount;
                $customer->save();
            }
            return redirect()->route("customers.show", $customer_uuid);
        }
        return view('transactions.edit', ['transaction' => $transaction]);
    }
    function approve(Request $request, $customer_uuid, $transaction_uuid)
    {
        $transaction = Transaction::where(['uuid' => $transaction_uuid, 'isDeleted' => 0])->firstOrFail();
        $transaction->isApproved = 1;
        $transaction->save();
        $customer = Customer::where('uuid', $customer_uuid)->firstOrFail();
        $customer->balance = $customer->balance + $transaction->amount;
        $customer->save();
        return redirect()->route('customers.show', $customer_uuid);
    }
    function delete($customer_uuid, $transaction_uuid)
    {
        $transaction = Transaction::where(['uuid' => $transaction_uuid])->firstOrFail();
        $transaction->isDeleted = 1;
        $customer = Customer::where('uuid', $customer_uuid)->firstOrFail();
        if ($transaction->isApproved == 1) {
            $customer->balance = $customer->balance - $transaction->amount;
            $customer->save();
        }
        $transaction->save();
        return redirect()->route('customers.show', $customer_uuid);
    }
}
