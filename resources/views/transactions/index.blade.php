@extends('layout')
@section('homecontent')
    <table class="table">
        <caption class="caption-top"><a href="{{ route('transactions.add', $customer->uuid) }}">Add Transaction</a> Name :
            {{ $customer->name }}, Balance : {{ $customer->balance }}</caption>
        <tr>
            <th>S. No.</th>
            <th>Description</th>
            <th>Amount</th>
            <th>Actions</th>
        </tr>
        @foreach ($transactions as $transaction)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $transaction->description }}</td>
                <td>{{ $transaction->amount }}</td>
                @if ($customer->user_id == auth()->user()->id)
                    @if ($transaction->isApproved)
                        <td><a href="{{ route('transactions.edit', [$customer->uuid, $transaction->uuid]) }}">Edit</a> | <a
                                href="{{ route('transactions.delete', [$customer->uuid, $transaction->uuid]) }}">Delete</a>
                        </td>
                    @else
                        <td><a href="{{ route('transactions.approve', [$customer->uuid, $transaction->uuid]) }}">Approve</a> | <a
                                href="{{ route('transactions.delete', [$customer->uuid, $transaction->uuid]) }}">Delete</a>
                        </td>
                    @endif
                @else
                    @if ($transaction->isApproved)
                        <td>Approved</td>
                    @else
                        <td><a href="{{ route('transactions.edit', [$customer->uuid, $transaction->uuid]) }}">Edit</a> | <a
                                href="{{ route('transactions.delete', [$customer->uuid, $transaction->uuid]) }}">Delete</a>
                        </td>
                    @endif
                @endif
            </tr>
        @endforeach
    </table>
@endsection
