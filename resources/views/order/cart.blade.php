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

                    <a href="{{ route('home') }}" class="btn btn-primary">Go To Home</a>
                    <a href="{{ route('orders') }}" class="btn btn-primary">Orders</a>
                    <a href="{{ route('checkout') }}" class="btn btn-primary">Place Order</a>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sr.no.</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach($products as $product)
                            <?php //echo "<pre>";print_r($product);die; ?>
                            <tr>
                                <td>{{ $i }}</td>
                                <td><img src="{{ URL::to('/') }}/images/{{ $product->image }}" height="100" width="100"></td>
                                <td>{{ $product->title }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->price }}</td>
                                <td>
                                    <a href="{{ route('removeProduct',['id'=>$product->id]) }}" class="btn btn-primary">Remove</a>
                                </td>
                            </tr>
                            <?php $i++; ?>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('checkout') }}" class="btn btn-primary">Place Order</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
