@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div>Welcome {{ $user->name }}, You are logged in!</div>

                    <a href="{{ route('home') }}" class="btn btn-primary">Home</a>
                    <a href="{{ route('cartPage') }}" class="btn btn-primary">Go To Cart</a>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sr.no.</th>
                                <th>Total</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $order->total }}</td>
                                <td>{{ $order->address }}</td>
                                <td>
                                    <a href="{{ route('editOrder',['id'=>$order->id]) }}" class="btn btn-primary">Edit</a>
                                    <a href="{{ route('viewOrder',['id'=>$order->id]) }}" class="btn btn-primary">View</a>
                                    <a href="{{ route('deleteOrder',['id'=>$order->id]) }}" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                            <?php $i++; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
