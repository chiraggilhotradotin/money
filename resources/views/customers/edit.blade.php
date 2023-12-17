@extends('layout')
@section('homecontent')
    <div class="container-fluid">
        <div class="row">
            <form method="post" class="col-md-6 offset-md-3">
                @csrf
                <div>
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" required class="form-control" value="{{$customer->name}}">
                </div>
                <div class="mt-4">
                    <input type="submit" class="w-100 btn btn-primary" value="Update">
                </div>
            </form>
        </div>
    </div>
@endsection
