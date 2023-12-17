@extends('layout')
@section('homecontent')
<table class="table">
    <tr>
        <th>S. No.</th>
        <th>Name</th>
        <th>Balance</th>
        <th>Actions</th>
    </tr>
    @foreach ($customers as $customer)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td><a href="{{route('customers.show',$customer->uuid)}}">{{$customer->name}} @if($customer->user_name) ( {{$customer->user_name}} ) @endif</a></td>
        <td>{{$customer->balance}}</td>
        <td>@if($customer->user_id == auth()->user()->id) <a href="{{route('customers.edit',$customer->uuid)}}">Edit</a> | <a href="{{route('customers.delete',$customer->uuid)}}">Delete</a> @endif</td>
    </tr>
    @endforeach
</table>
@endsection
