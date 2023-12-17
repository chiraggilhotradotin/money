<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    function index()
    {
        $customers = Customer::where(['customers.customer_user_id' => auth()->user()->id, 'isDeleted' => 0])->join('users','users.id','=','customers.user_id')->select('customers.*','users.name as user_name')->get();
        return view('customers.index', ['customers' => $customers]);
    }
}
