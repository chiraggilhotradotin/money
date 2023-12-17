@extends('layout')
@section('homecontent')
    <div class="container-fluid">
        <div class="row">
            <form method="post" class="col-md-6 offset-md-3">
                @csrf
                <div>
                    <label for="amount">Amount</label>
                    <input type="number" name="amount" id="amount" required class="form-control" value="{{$transaction->amount}}">
                </div>
                <div class="mt-3">
                    <label for="description">Description</label>
                    <textarea type="number" name="description" rows="5" id="description" required class="form-control">{{$transaction->description}}</textarea>
                </div>
                <div class="mt-4">
                    <input type="submit" class="w-100 btn btn-primary" value="Update">
                </div>
            </form>
        </div>
    </div>
@endsection
