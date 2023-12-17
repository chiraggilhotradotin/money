@extends('root')
@section('content')
    @include('navbar')
    <div class="my-4"><a href="{{ route('customers.add') }}">Add</a> | <a href="{{ route('customers') }}">Customers</a> | <a href="{{ route('businesses') }}">Businesses</a> | Your id : {{auth()->user()->uuid??''}}</div>
    @yield('homecontent')
    @include('footer')
@endsection
